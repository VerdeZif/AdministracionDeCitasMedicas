<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Dependent;
use App\Models\Headquarter;
use App\Models\Specialty;
use App\Models\User;
use App\Services\AvailabilityService;
use App\Services\Payments\PaymentGatewayInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    protected $paymentGateway;

    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /*
    |--------------------------------------------------------------------------
    | Dashboards
    |--------------------------------------------------------------------------
    */
    public function patientDashboard()
    {
        // Limpia reservas sin pagar que ya vencieron
        Appointment::where('patient_id', Auth::id())
            ->where('status', 'Pendiente de Pago')
            ->where('created_at', '<', now()->subMinutes(AvailabilityService::HOLD_MINUTES))
            ->delete();

        $appointments = Appointment::with(['doctor', 'specialty', 'headquarter'])
            ->where('patient_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('patient.dashboard', compact('appointments'));
    }

    public function doctorDashboard()
    {
        $appointments = Appointment::with(['patient', 'specialty'])
            ->where('doctor_id', Auth::id())
            ->whereDate('date', today())
            ->orderBy('time', 'asc')
            ->get();

        return view('doctor.dashboard', compact('appointments'));
    }

    public function adminAppointments(Request $request)
    {
        $query = Appointment::with([
                'patient'     => fn ($q) => $q->withTrashed(),
                'doctor'      => fn ($q) => $q->withTrashed(),
                'specialty',
                'headquarter',
                'invoice',
            ])
            // Oculta reservas sin pagar que ya vencieron
            ->where(fn ($q) => $q->where('status', '!=', 'Pendiente de Pago')
                ->orWhere('created_at', '>=', now()->subMinutes(AvailabilityService::HOLD_MINUTES)));

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Las más recientemente registradas primero
        $appointments = $query->orderByDesc('created_at')->orderByDesc('id')
            ->paginate(10)->withQueryString();

        $stats = [
            'total'      => Appointment::count(),
            'pendientes' => Appointment::where('status', 'Pendiente de Pago')
                                ->where('created_at', '>=', now()->subMinutes(AvailabilityService::HOLD_MINUTES))->count(),
            'hoy'        => Appointment::whereDate('date', today())->count(),
            'ingresos'   => \App\Models\Invoice::sum('amount'),
            'medicos'    => User::where('role', 'doctor')->count(),
            'pacientes'  => User::where('role', 'patient')->count(),
            'sedes'      => Headquarter::count(),
        ];

        return view('admin.dashboard', compact('appointments', 'stats'));
    }
    /*
    |--------------------------------------------------------------------------
    | Flujo del paciente: reservar y pagar
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $specialties = Specialty::all();
        $headquarters = Headquarter::all();
        $doctors = User::where('role', 'doctor')->get();

        return view('patient.book', compact('specialties', 'headquarters', 'doctors'));
    }

    public function store(Request $request, AvailabilityService $svc)
    {
        $data = $request->validate([
            'patient_type'   => 'required|in:titular,dependiente',
            'dependent_name' => 'required_if:patient_type,dependiente|nullable|string|max:255',
            'dependent_dni'  => 'required_if:patient_type,dependiente|nullable|string|max:20',
            'headquarter_id' => 'required|exists:headquarters,id',
            'specialty_id'   => 'required|exists:specialties,id',
            'doctor_id'      => 'nullable|exists:users,id',
            'date'           => 'required|date|after_or_equal:today',
            'time'           => 'required|date_format:H:i',
        ]);

        $specialtyId = (int) $data['specialty_id'];
        $doctorId = $request->integer('doctor_id') ?: null;

        $appointment = DB::transaction(function () use ($data, $svc, $specialtyId, $doctorId) {
            $date = Carbon::parse($data['date']);

            // Evita que dos pacientes tomen el mismo horario a la vez
            User::whereIn('id', $svc->doctorIds($specialtyId, $doctorId))->lockForUpdate()->get();

            $free = $svc->availability($date, $date, $specialtyId, $doctorId)[$date->toDateString()][$data['time']] ?? [];
            if (!$free) {
                throw ValidationException::withMessages(['time' => 'Ese horario ya fue tomado. Elige otro.']);
            }

            $dependent = null;
            if ($data['patient_type'] === 'dependiente') {
                $dependent = Dependent::firstOrCreate(
                    ['user_id' => Auth::id(), 'dni' => $data['dependent_dni']],
                    ['full_name' => $data['dependent_name'], 'relationship' => 'Familiar']
                );
            }

            return Appointment::create([
                'patient_id'     => Auth::id(),
                'dependent_id'   => $dependent?->id,
                'doctor_id'      => $free[0],
                'headquarter_id' => $data['headquarter_id'],
                'specialty_id'   => $specialtyId,
                'date'           => $data['date'],
                'time'           => $data['time'],
                'status'         => 'Pendiente de Pago',
            ]);
        });

        return redirect()->route('patient.appointments.reserve', $appointment);
    }

    public function reserve(Appointment $appointment)
    {
        abort_unless($appointment->patient_id === Auth::id(), 403);

        if ($appointment->status !== 'Pendiente de Pago') {
            return redirect()->route('patient.dashboard');
        }

        if ($appointment->created_at->lt(now()->subMinutes(AvailabilityService::HOLD_MINUTES))) {
            $appointment->delete();
            return redirect()->route('patient.appointments.create')
                ->withErrors(['time' => 'El tiempo de reserva venció. Elige otro horario.']);
        }

        $appointment->load(['specialty', 'doctor', 'headquarter', 'dependent']);
        return view('patient.reserve', compact('appointment'));
    }

    public function pay(Request $request, Appointment $appointment)
    {
        abort_unless($appointment->patient_id === Auth::id(), 403);

        if ($appointment->status !== 'Pendiente de Pago') {
            return response()->json(['message' => 'Esta cita ya fue pagada.'], 409);
        }

        if ($appointment->created_at->lt(now()->subMinutes(AvailabilityService::HOLD_MINUTES))) {
            $appointment->delete();
            return response()->json([
                'message'  => 'El tiempo de reserva venció. Elige otro horario.',
                'redirect' => route('patient.appointments.create'),
            ], 410);
        }

        $method = $request->validate([
            'method' => 'required|in:tarjeta,yape,plin,pagoefectivo',
        ])['method'];

        // Validaciones según el método (los datos nunca se guardan)
        switch ($method) {
            case 'tarjeta':
                $request->validate([
                    'card_name'   => 'required|string|max:100',
                    'card_number' => 'required|string|min:13|max:23',
                    'expiry'      => ['required', 'regex:/^\d{2}\/\d{2}$/'],
                    'cvv'         => 'required|digits_between:3,4',
                ]);
                if (preg_replace('/\D/', '', $request->card_number) === '4000000000000002') {
                    return response()->json(['message' => 'Tarjeta rechazada (simulación).'], 422);
                }
                break;

            case 'yape':
                $request->validate([
                    'phone' => 'required|digits:9',
                    'code'  => 'required|digits:6',
                ]);
                if ($request->code === '000000') {
                    return response()->json(['message' => 'Código de Yape rechazado (simulación).'], 422);
                }
                break;

            case 'plin':
                $request->validate(['phone' => 'required|digits:9']);
                break;

            case 'pagoefectivo':
                $request->validate(['cip' => 'required|digits:8']);
                break;
        }

        $labels = [
            'tarjeta'      => 'Tarjeta (simulada)',
            'yape'         => 'Yape (simulado)',
            'plin'         => 'Plin (simulado)',
            'pagoefectivo' => 'PagoEfectivo (simulado)',
        ];

        $amount = $appointment->specialty->price;

        try {
            DB::transaction(function () use ($appointment, $amount, $method, $labels) {
                $response = $this->paymentGateway->processPayment($amount, 'tarjeta_credito', [
                    'patient_id'     => Auth::id(),
                    'appointment_id' => $appointment->id,
                    'method'         => $method,
                ]);

                if (($response['status'] ?? null) !== 'success') {
                    throw new \Exception('El pago fue rechazado por la pasarela.');
                }

                $appointment->update(['status' => 'Confirmada']);
                $appointment->invoice()->create([
                    'amount'         => $amount,
                    'payment_method' => $labels[$method],
                ]);
            });
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(['ok' => true, 'redirect' => route('patient.dashboard')]);
    }

    public function cancel(Appointment $appointment)
    {
        abort_unless($appointment->patient_id === Auth::id(), 403);

        if ($appointment->status !== 'Pendiente de Pago') {
            return redirect()->route('patient.dashboard')
                ->withErrors(['cancel' => 'Solo se pueden cancelar reservas pendientes de pago.']);
        }

        $appointment->delete();

        return redirect()->route('patient.dashboard')
            ->with('success', 'Reserva cancelada. El horario quedó libre.');
    }

    /*
    |--------------------------------------------------------------------------
    | Disponibilidad (API interna)
    |--------------------------------------------------------------------------
    */
    public function getAvailableHours(Request $request, AvailabilityService $svc)
    {
        $request->validate([
            'date'         => 'required|date',
            'specialty_id' => 'required|integer',
            'doctor_id'    => 'nullable|integer',
        ]);

        $date = Carbon::parse($request->date);
        $data = $svc->availability($date, $date, $request->integer('specialty_id'), $request->integer('doctor_id') ?: null);

        return response()->json(array_keys($data[$date->toDateString()] ?? []));
    }

    public function monthAvailability(Request $request, AvailabilityService $svc)
    {
        $request->validate([
            'month'        => 'required|date_format:Y-m',
            'specialty_id' => 'required|integer',
            'doctor_id'    => 'nullable|integer',
        ]);

        $from = Carbon::createFromFormat('!Y-m', $request->month)->startOfMonth();
        $data = $svc->availability($from, $from->copy()->endOfMonth(),
            $request->integer('specialty_id'), $request->integer('doctor_id') ?: null);

        return response()->json(collect($data)->map(fn ($slots) => count($slots)));
    }

    /*
    |--------------------------------------------------------------------------
    | Otras operaciones
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $appointments = Appointment::where('patient_id', Auth::id())->orderBy('date', 'desc')->get();
        return view('patient.history', compact('appointments'));
    }

    public function doctorAppointments()
    {
        $appointments = Appointment::with(['patient'])
            ->where('doctor_id', Auth::id())
            ->orderBy('date', 'asc')
            ->get();

        return view('doctor.appointments', compact('appointments'));
    }

    public function updateStatus(Request $request, Appointment $appointment)
    {
        if (Auth::user()->role === 'doctor' && $appointment->doctor_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:Confirmada,En Curso,Atendida,Ausente',
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', 'Estado de la cita actualizado correctamente.');
    }

    public function downloadPdf(Appointment $appointment)
    {
        if ($appointment->patient_id !== Auth::id()) {
            abort(403, 'No autorizado.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.appointment', compact('appointment'));

        return $pdf->download('Comprobante_Reserva_' . $appointment->id . '.pdf');
    }
}
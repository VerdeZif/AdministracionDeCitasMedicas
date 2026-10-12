<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorBlock;
use App\Models\Headquarter;
use App\Models\Specialty;
use App\Models\User;
use App\Services\Payments\PaymentGatewayInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    protected $paymentGateway;

    // Inyectamos la interfaz de pagos.
    public function __construct(PaymentGatewayInterface $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }

    /*
    |--------------------------------------------------------------------------
    | Vistas de Dashboards Privados
    |--------------------------------------------------------------------------
    */
    public function patientDashboard()
    {
        $appointments = Appointment::with(['doctor', 'specialty', 'headquarter'])
            ->where('patient_id', Auth::id())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return view('patient.dashboard', compact('appointments'));
    }

    public function doctorDashboard()
    {
        // Citas del día para el médico logueado
        $appointments = Appointment::with(['patient', 'specialty'])
            ->where('doctor_id', Auth::id())
            ->whereDate('date', today())
            ->orderBy('time', 'asc')
            ->get();

        return view('doctor.dashboard', compact('appointments'));
    }

    public function adminAppointments()
    {
        $appointments = Appointment::with(['patient', 'doctor', 'specialty', 'headquarter'])
            ->orderBy('date', 'desc')
            ->take(15) // Limitamos a las 15 más recientes para el panel
            ->get();
            
        // Sumamos los ingresos (boletas)
        $totalIngresos = \App\Models\Invoice::sum('amount');
        
        return view('admin.dashboard', compact('appointments', 'totalIngresos'));
    }

    /*
    |--------------------------------------------------------------------------
    | Flujo del Paciente: Reservar y Pagar
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $specialties = Specialty::all();
        $headquarters = Headquarter::all();
        // Solo traemos a los usuarios que tengan el rol de doctor
        $doctors = User::where('role', 'doctor')->get(); 

        return view('patient.book', compact('specialties', 'headquarters', 'doctors'));
    }

    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            'specialty_id'   => 'required|exists:specialties,id',
            'headquarter_id' => 'required|exists:headquarters,id',
            'doctor_id'      => 'required|exists:users,id',
            'date'           => 'required|date|after_or_equal:today',
            'time'           => 'required|date_format:H:i',
            'payment_method' => 'required|string',
        ]);

        // 2. Lógica de Negocio: Verificar disponibilidad del médico
        $isBooked = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('date', $validated['date'])
            ->where('time', $validated['time'])
            ->whereIn('status', ['Confirmada', 'Pendiente de Pago', 'En Curso'])
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['time' => 'El horario seleccionado ya está ocupado por otro paciente.'])->withInput();
        }

        $isBlocked = DoctorBlock::where('doctor_id', $validated['doctor_id'])
            ->where('date', $validated['date'])
            ->where('start_time', '<=', $validated['time'])
            ->where('end_time', '>=', $validated['time'])
            ->exists();

        if ($isBlocked) {
            return back()->withErrors(['time' => 'El médico no está disponible en el horario seleccionado (Bloqueo de agenda).'])->withInput();
        }

        // 3. Obtener el precio de la especialidad para el pago
        $specialty = Specialty::findOrFail($validated['specialty_id']);
        $amount = $specialty->price;

        // 4. TRANSACCIÓN ATÓMICA
        try {
            DB::beginTransaction();

            // A. Procesamos el pago a través del servicio simulado (Mock)
            $paymentResponse = $this->paymentGateway->processPayment($amount, $validated['payment_method'], [
                'patient_id' => Auth::id(),
                'date' => $validated['date']
            ]);

            if ($paymentResponse['status'] !== 'success') {
                throw new \Exception('El pago fue rechazado por la pasarela.');
            }

            // B. Creamos la cita
            $appointment = Appointment::create([
                'patient_id'     => Auth::id(),
                'doctor_id'      => $validated['doctor_id'],
                'headquarter_id' => $validated['headquarter_id'],
                'specialty_id'   => $validated['specialty_id'],
                'date'           => $validated['date'],
                'time'           => $validated['time'],
                'status'         => 'Confirmada', 
            ]);

            // C. Generamos la boleta
            $appointment->invoice()->create([
                'amount'         => $amount,
                'payment_method' => $paymentResponse['method'],
            ]);

            DB::commit();

            return redirect()->route('patient.dashboard')->with('success', '¡Cita reservada y pagada con éxito! Código de transacción: ' . $paymentResponse['transaction_id']);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error_general' => 'Ocurrió un error al procesar tu reserva: ' . $e->getMessage()])->withInput();
        }
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
            'status' => 'required|in:Confirmada,En Curso,Atendida,Ausente'
        ]);

        $appointment->update(['status' => $validated['status']]);

        return back()->with('success', 'Estado de la cita actualizado correctamente.');
    }

    public function getAvailableHours(\Illuminate\Http\Request $request)
    {
        $date = $request->date;
        $doctorId = $request->doctor_id;
        
        // Estos son los turnos base de la clínica
        $allHours = ['08:00', '08:30', '09:00', '10:30', '11:00', '14:30', '15:00', '16:30'];
        
        if (!$doctorId) {
            return response()->json($allHours);
        }

        // Buscamos qué horas ya están reservadas para ese médico en esa fecha
        $bookedHours = Appointment::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->whereIn('status', ['Confirmada', 'Pendiente de Pago', 'En Curso'])
            ->pluck('time')
            ->map(function($time) {
                // Formateamos de "08:30:00" a "08:30" para poder comparar
                return \Carbon\Carbon::parse($time)->format('H:i');
            })
            ->toArray();
        
        // Filtramos: quitamos las horas ocupadas de la lista total
        $availableHours = array_values(array_diff($allHours, $bookedHours));
        
        return response()->json($availableHours);
    }

    public function downloadPdf(Appointment $appointment)
    {
        // Por seguridad, validamos que el paciente que descarga sea el dueño de la cita
        if ($appointment->patient_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403, 'No autorizado.');
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.appointment', compact('appointment'));
        
        return $pdf->download('Comprobante_Reserva_' . $appointment->id . '.pdf');
    }
}
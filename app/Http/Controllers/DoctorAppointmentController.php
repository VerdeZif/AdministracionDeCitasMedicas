<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['fecha' => 'nullable|date']);

        $date = $request->filled('fecha') ? Carbon::parse($request->fecha) : today();

        $appointments = Appointment::with(['patient', 'dependent', 'specialty', 'headquarter'])
            ->where('doctor_id', auth()->id())
            ->whereDate('date', $date)
            ->orderBy('time')
            ->get();

        $stats = [
            // Las canceladas no cuentan como citas del día
            'total'      => $appointments->where('status', '!=', 'Cancelada')->count(),
            'pendientes' => $appointments->whereIn('status', ['Confirmada', 'En Curso'])->count(),
            'atendidas'  => $appointments->where('status', 'Atendida')->count(),
            'ausentes'   => $appointments->where('status', 'Ausente')->count(),
        ];

        // Citas de días anteriores que el médico olvidó cerrar
        $anteriores = Appointment::where('doctor_id', auth()->id())
            ->whereIn('status', ['Confirmada', 'En Curso'])
            ->whereDate('date', '<', today());

        $sinCerrar = [
            'total' => $anteriores->count(),
            'desde' => $anteriores->min('date'),
        ];

        return view('doctor.dashboard', compact('appointments', 'date', 'stats', 'sinCerrar'));
    }

    public function start(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment, ['Confirmada'], 'not_future');

        $appointment->update(['status' => 'En Curso']);

        return back()->with('success', 'Consulta iniciada.');
    }

    public function finish(Request $request, Appointment $appointment)
    {
        $this->authorizeAppointment($appointment, ['En Curso'], 'not_future');

        $data = $request->validate([
            'diagnosis'      => 'required|string|min:5|max:2000',
            'instructions'   => 'required|string|min:5|max:2000',
            'follow_up_date' => 'nullable|date|after:today',
        ]);

        $appointment->forceFill([
            'status'         => 'Atendida',
            'diagnosis'      => $data['diagnosis'],
            'instructions'   => $data['instructions'],
            'follow_up_date' => $data['follow_up_date'] ?? null,
            'attended_at'    => now(),
        ])->save();

        return back()->with('success', 'Consulta finalizada y registrada.');
    }

    public function absent(Appointment $appointment)
    {
        $this->authorizeAppointment($appointment, ['Confirmada'], 'not_future');

        $appointment->update(['status' => 'Ausente']);

        return back()->with('success', 'Paciente marcado como ausente.');
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        // Se puede cancelar hoy o en fechas futuras, nunca una cita ya iniciada o cerrada
        $this->authorizeAppointment($appointment, ['Pendiente de Pago', 'Confirmada'], 'not_past');

        $data = $request->validate([
            'reason' => 'required|string|min:5|max:255',
        ]);

        $appointment->forceFill([
            'status'              => 'Cancelada',
            'cancelled_by'        => 'doctor',
            'cancellation_reason' => $data['reason'],
            'cancelled_at'        => now(),
            // Si ya existe una factura, el paciente pagó: queda pendiente de reembolso
            'refund_pending'      => $appointment->invoice()->exists(),
        ])->save();

        return back()->with('success', 'Cita cancelada. El paciente verá el motivo en su panel.');
    }

    private function authorizeAppointment(Appointment $appointment, array $allowedStatuses, string $when = 'today'): void
    {
        abort_unless($appointment->doctor_id === auth()->id(), 403);

        $date = Carbon::parse($appointment->date)->startOfDay();

        if ($when === 'today') {
            abort_unless($date->isToday(), 403, 'Solo puedes gestionar citas del día de hoy.');
        } elseif ($when === 'not_future') {
            abort_unless($date->lte(today()), 403, 'Esa cita todavía no ocurre.');
        } elseif ($when === 'not_past') {
            abort_unless($date->gte(today()), 403, 'No puedes modificar citas de fechas pasadas.');
        }

        abort_unless(
            in_array($appointment->status, $allowedStatuses),
            422,
            'Estado de cita no válido para esta acción.'
        );
    }
}
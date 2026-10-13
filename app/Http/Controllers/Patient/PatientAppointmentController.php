<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Invoice;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PatientAppointmentController extends Controller
{
    // Reservar Cita y Generar Comprobante
    public function store(Request $request)
    {
        $request->validate([
            'doctor_id'      => 'required|exists:users,id',
            'headquarter_id' => 'required|exists:headquarters,id',
            'specialty_id'   => 'required|exists:specialties,id',
            'date'           => 'required|date',
            'time'           => 'required',
            'payment_method' => 'required|string', // ej: 'Yape', 'Efectivo en Clínica', 'Tarjeta'
        ]);

        return DB::transaction(function () use ($request) {
            // 1. Crear Cita Médica
            $appointment = Appointment::create([
                'patient_id'     => auth()->id(),
                'doctor_id'      => $request->doctor_id,
                'headquarter_id' => $request->headquarter_id,
                'specialty_id'   => $request->specialty_id,
                'date'           => $request->date,
                'time'           => $request->time,
                'status'         => 'confirmed',
            ]);

            // 2. Generar Comprobante Simulado (Invoice)
            $specialty = Specialty::findOrFail($request->specialty_id);
            $invoice = Invoice::create([
                'appointment_id' => $appointment->id,
                'amount'         => $specialty->price,
                'payment_method' => $request->payment_method,
            ]);

            return response()->json([
                'message'     => '¡Cita reservada con éxito!',
                'appointment' => $appointment->load(['doctor', 'headquarter', 'specialty']),
                'invoice'     => $invoice
            ], 201);
        });
    }

    // Ver mis Citas como Paciente
    public function myAppointments()
    {
        $appointments = Appointment::with(['doctor', 'headquarter', 'specialty', 'invoice'])
            ->where('patient_id', auth()->id())
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->get();

        return response()->json($appointments);
    }
}
<?php
namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DoctorAppointmentController extends Controller
{
    // Ver los pacientes a atender
    public function mySchedule(Request $request)
    {
        $doctorId = auth()->id();
        $date = $request->query('date', date('Y-m-d')); // Por defecto las de hoy

        $appointments = Appointment::with(['patient', 'headquarter', 'specialty'])
            ->where('doctor_id', $doctorId)
            ->where('date', $date)
            ->orderBy('time', 'asc')
            ->get();

        return response()->json([
            'date' => $date,
            'patients_to_attend' => $appointments
        ]);
    }

    // Cambiar estado a "atendido" o "cancelado"
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:pending,confirmed,completed,cancelled']);

        $appointment = Appointment::where('doctor_id', auth()->id())->findOrFail($id);
        $appointment->update(['status' => $request->status]);

        return response()->json(['message' => 'Estado actualizado correctamente.', 'appointment' => $appointment]);
    }
}

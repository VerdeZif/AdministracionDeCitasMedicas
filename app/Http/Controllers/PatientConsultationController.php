<?php

namespace App\Http\Controllers;

use App\Models\Appointment;

class PatientConsultationController extends Controller
{
    public function show(Appointment $appointment)
    {
        // Solo el paciente dueño de la cita puede verla
        abort_unless($appointment->patient_id === auth()->id(), 403);

        $appointment->load(['doctor', 'specialty', 'headquarter']);

        return view('patient.appointments.show', compact('appointment'));
    }
}
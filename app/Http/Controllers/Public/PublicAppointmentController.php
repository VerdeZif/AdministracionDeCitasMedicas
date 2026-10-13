<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Headquarter;
use App\Models\Specialty;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;

class PublicAppointmentController extends Controller
{
    // Obtener sedes y especialidades para los desplegables iniciales
    public function getFormFilters()
    {
        return response()->json([
            'headquarters' => Headquarter::select('id', 'name', 'address')->get(),
            'specialties'  => Specialty::select('id', 'name', 'price')->get(),
        ]);
    }

    // Filtrar médicos según la sede y especialidad elegidas
    public function getDoctors(Request $request)
    {
        $doctors = User::where('role', 'doctor')
            ->where('specialty_id', $request->specialty_id)
            ->get(['id', 'name', 'email']);

        return response()->json($doctors);
    }

    // Obtener horarios disponibles para un médico en una fecha específica
    public function getAvailableSlots(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:users,id',
            'date'      => 'required|date_format:Y-m-d'
        ]);

        $doctorId = $request->doctor_id;
        $date     = $request->date;

        // Horarios estándar de atención (8:00 AM a 1:00 PM y 3:00 PM a 6:00 PM cada 30 min)
        $allSlots = [
            '08:00', '08:30', '09:00', '09:30', '10:00', '10:30', '11:00', '11:30',
            '15:00', '15:30', '16:00', '16:30', '17:00', '17:30'
        ];

        // Obtener horas ya reservadas que no estén canceladas
        $bookedSlots = Appointment::where('doctor_id', $doctorId)
            ->where('date', $date)
            ->where('status', '!=', 'cancelled')
            ->pluck('time')
            ->toArray();

        // Filtrar horas libres
        $availableSlots = array_values(array_diff($allSlots, $bookedSlots));

        return response()->json([
            'date' => $date,
            'available_slots' => $availableSlots
        ]);
    }
}

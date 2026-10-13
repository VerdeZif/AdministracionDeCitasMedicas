<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Specialty;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DoctorManagementController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->with('specialty')
            ->orderBy('last_name_paternal')->orderBy('name')->get();
        $specialties = Specialty::orderBy('name')->get();

        return view('admin.doctors.index', compact('doctors', 'specialties'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'last_name_paternal' => 'required|string|max:255',
            'last_name_maternal' => 'required|string|max:255',
            'dni'                => 'required|digits:8|unique:users,dni',
            'birth_date'         => 'required|date|before:today',
            'phone'              => 'nullable|string|max:20',
            'gender'             => 'required|in:M,F',
            'email'              => 'required|email|max:255|unique:users,email',
            'specialty_id'       => 'required|exists:specialties,id',
            'password'           => 'required|string|min:8',
        ]);

        // array_merge (y no "+") para que el password hasheado reemplace al de texto plano
        User::create(array_merge($data, [
            'document_type'     => 'DNI',
            'role'              => 'doctor',
            'email_verified_at' => now(),
            'password'          => Hash::make($data['password']),
        ]));

        return back()->with('success', 'Médico registrado con éxito.');
    }

    public function update(Request $request, $id)
    {
        $doctor = User::where('role', 'doctor')->findOrFail($id);

        $data = $request->validate([
            'name'               => 'required|string|max:255',
            'last_name_paternal' => 'required|string|max:255',
            'last_name_maternal' => 'required|string|max:255',
            'dni'                => 'required|digits:8|unique:users,dni,' . $doctor->id,
            'birth_date'         => 'required|date|before:today',
            'phone'              => 'nullable|string|max:20',
            'gender'             => 'required|in:M,F',
            'email'              => 'required|email|max:255|unique:users,email,' . $doctor->id,
            'specialty_id'       => 'required|exists:specialties,id',
            'password'           => 'nullable|string|min:8',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $doctor->update($data);

        return back()->with('success', 'Médico actualizado.');
    }

    public function destroy($id)
    {
        $doctor = User::where('role', 'doctor')->findOrFail($id);

        $hasUpcoming = Appointment::where('doctor_id', $doctor->id)
            ->whereIn('status', ['Pendiente de Pago', 'Confirmada', 'En Curso'])
            ->whereDate('date', '>=', today())
            ->exists();

        if ($hasUpcoming) {
            return back()->withErrors(['delete' => 'No se puede eliminar: el médico tiene citas pendientes o confirmadas.']);
        }

        $doctor->delete(); // SoftDelete: conserva el historial de citas

        return back()->with('success', 'Médico eliminado.');
    }
}
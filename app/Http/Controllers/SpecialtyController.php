<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return view('admin.specialties.index', compact('specialties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255|unique:specialties,name',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        Specialty::create($validated);
        return back()->with('success', 'Especialidad creada con éxito.');
    }

    public function update(Request $request, Specialty $specialty)
    {
        $validated = $request->validate([
            // Ignoramos el ID actual para que la regla 'unique' no falle al actualizar
            'name'        => 'required|string|max:255|unique:specialties,name,' . $specialty->id,
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
        ]);

        $specialty->update($validated);
        return back()->with('success', 'Especialidad actualizada correctamente.');
    }

    public function destroy(Specialty $specialty)
    {
        // La restricción cascadeOnDelete/restrictOnDelete de la base de datos que hiciste antes 
        // bloqueará esto si la especialidad ya tiene citas. ¡Esa es la magia de tu diseño!
        try {
            $specialty->delete();
            return back()->with('success', 'Especialidad eliminada.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No puedes eliminar esta especialidad porque ya tiene médicos o citas asignadas.']);
        }
    }
}
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
        if ($specialty->doctors()->exists()) {
            return back()->withErrors(['delete' => 'No se puede eliminar: hay médicos asignados a esta especialidad.']);
        }

        try {
            $specialty->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->withErrors(['delete' => 'No se puede eliminar: la especialidad tiene citas registradas.']);
        }

        return redirect()->route('admin.especialidades.index')->with('success', 'Especialidad eliminada.');
    }
}
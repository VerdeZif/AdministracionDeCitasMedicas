<?php

namespace App\Http\Controllers;

use App\Models\DoctorBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorBlockController extends Controller
{
    // Mostrar la lista de bloqueos del doctor autenticado
    public function index()
    {
        $blocks = DoctorBlock::where('doctor_id', Auth::id())
                    ->orderBy('date', 'desc')
                    ->get();
                    
        return view('doctor.blocks.index', compact('blocks'));
    }

    // Guardar un nuevo bloqueo
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date'       => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
            'reason'     => 'required|string|max:255',
        ]);

        DoctorBlock::create([
            'doctor_id'  => Auth::id(), // Obligamos a que el bloqueo sea para el doctor logueado
            'date'       => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time'   => $validated['end_time'],
            'reason'     => $validated['reason'],
        ]);

        return back()->with('success', 'Horario bloqueado correctamente. Los pacientes no podrán reservar en este lapso.');
    }

    // Eliminar un bloqueo (por si el doctor se arrepiente)
    public function destroy(DoctorBlock $doctorBlock)
    {
        // Seguridad: Evitar que un doctor borre el bloqueo de otro doctor
        if ($doctorBlock->doctor_id !== Auth::id()) {
            abort(403, 'Acción no autorizada.');
        }

        $doctorBlock->delete();

        return back()->with('success', 'Bloqueo de horario eliminado. La agenda vuelve a estar libre.');
    }
}
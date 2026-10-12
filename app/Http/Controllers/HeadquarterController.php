<?php

namespace App\Http\Controllers;

use App\Models\Headquarter;
use Illuminate\Http\Request;

class HeadquarterController extends Controller
{
    public function index()
    {
        $headquarters = Headquarter::all();
        return view('admin.headquarters.index', compact('headquarters'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255|unique:headquarters,name',
            'address' => 'required|string|max:255',
        ]);

        Headquarter::create($validated);
        return back()->with('success', 'Sede registrada con éxito.');
    }

    public function update(Request $request, Headquarter $headquarter)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255|unique:headquarters,name,' . $headquarter->id,
            'address' => 'required|string|max:255',
        ]);

        $headquarter->update($validated);
        return back()->with('success', 'Sede actualizada correctamente.');
    }

    public function destroy(Headquarter $headquarter)
    {
        try {
            $headquarter->delete();
            return back()->with('success', 'Sede eliminada.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'No puedes eliminar esta sede porque tiene citas programadas.']);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    /**
     * Muestra la lista de aeronaves.
     */
    public function index()
    {
        $aircrafts = Aircraft::all();
        return view('aircraft.index', compact('aircrafts'));
    }

    /**
     * Guarda una nueva aeronave.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration' => 'required|unique:aircraft|max:20',
            'brand'        => 'required|string|max:100',
            'model'        => 'required|string|max:100',
        ]);

        // Estandarizamos la matrícula a mayúsculas (Ej: tg-abc -> TG-ABC)
        $validated['registration'] = strtoupper($request->registration);

        Aircraft::create($validated);

        #return redirect()->route('aircraft.index')->with('success', 'Aeronave registrada con éxito.');
        return redirect()->back()->with('success', 'Aeronave registrada con éxito.');
    }

    /**
     * Alternar el estado (Activo/Inactivo).
     * Recuerda que en aviación preferimos desactivar antes que borrar.
     */
    public function toggleStatus(Aircraft $aircraft)
    {
        $aircraft->update(['is_active' => !$aircraft->is_active]);
        return redirect()->back()->with('success', 'Estado de la aeronave actualizado.');
    }

    /**
     * Eliminar físicamente (Solo para el Admin y si no hay bitácoras).
     */
    public function destroy(Aircraft $aircraft)
    {
        // Verificación de seguridad para el Admin
        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar aeronaves.');
        }

        try {
            $aircraft->delete();
            return redirect()->back()->with('success', 'Aeronave eliminada del sistema.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se puede eliminar: esta aeronave ya tiene registros de vuelo.');
        }
    }
}
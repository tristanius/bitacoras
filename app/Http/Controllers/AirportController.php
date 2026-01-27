<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        // Traemos todos los aeropuertos para listarlos
        $airports = Airport::all();
        return view('airports.index', compact('airports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'icao_code' => 'required|unique:airports|max:4',
            'name'      => 'required|string|max:255',
        ]);

        // Forzamos el código a mayúsculas antes de guardar
        $validated['icao_code'] = strtoupper($validated['icao_code']);

        \App\Models\Airport::create($validated);

        return redirect()->route('airports.index')->with('success', 'Aeropuerto creado.');
    }

    public function toggleStatus(Airport $airport)
    {
        // Cambiamos el estado de activo a inactivo y viceversa
        $airport->update(['is_active' => !$airport->is_active]);
        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    public function destroy(Airport $airport)
    {
        // Verificamos que sea Admin (aunque ya lo protegemos en la ruta)
        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('error', 'No tienes permisos para eliminar.');
        }

        try {
            $airport->delete();
            return redirect()->back()->with('success', 'Aeropuerto eliminado correctamente.');
        } catch (\Exception $e) {
            // Esto captura errores de integridad referencial (si tiene relaciones)
            return redirect()->back()->with('error', 'No se puede eliminar: tiene registros relacionados.');
        }
    }
}
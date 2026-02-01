<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\AircraftModel;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    /**
     * Muestra la lista de aeronaves.
     */
    public function index()
    {
        // Traemos las aeronaves con su modelo y la categoría de ese modelo
        $aircrafts = Aircraft::with('aircraft_model.category')->get();
        
        // Traemos los modelos para el select del Modal
        $models = AircraftModel::with('category')->get(); 
        
        return view('aircrafts.index', compact('aircrafts', 'models'));
    }

    /**
     * Guarda una nueva aeronave.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration' => 'required|unique:aircraft|max:20',
            #'brand'        => 'required|string|max:100',
            'aircraft_model_id' => 'required|exists:aircraft_models,id', // El select
        ]);

        // Estandarizamos la matrícula a mayúsculas (Ej: tg-abc -> TG-ABC)
        $validated['registration'] = strtoupper($request->registration);

        Aircraft::create($validated);

        #return redirect()->route('aircraft.index')->with('success', 'Aeronave registrada con éxito.');
        return redirect()->back()->with('success', 'Aeronave registrada con éxito.');
    }

    public function update(Request $request, Aircraft $aircraft)
    {
        $validated = $request->validate([
            'registration' => 'required|unique:aircraft,registration,' . $aircraft->id,
            'aircraft_model_id' => 'required|exists:aircraft_models,id',
        ]);

        $aircraft->update($validated);

        return redirect()->back()->with('success', 'Aeronave actualizada.');
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
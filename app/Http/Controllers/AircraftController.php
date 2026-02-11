<?php

namespace App\Http\Controllers;

use App\Models\Aircraft;
use App\Models\AircraftModel;
use Illuminate\Http\Request;

class AircraftController extends Controller
{
    /**
     * Muestra la lista de aeronaves.
     * $aircrafts = Aircraft::with('aircraft_model.category')->get();
     */
    public function index()
    {
        $user = auth()->user();
        $aircrafts = [];
        if ($user->hasRole('Admin')) {
            $aircrafts = Aircraft::with('aircraft_model.category')->get();
        } else {
            // Solo traemos las aeronaves que pertenecen al piloto autenticado
            $aircrafts = auth()->user()->aircrafts()->with('aircraft_model.category')->get();
        }
        
        // Los modelos siguen siendo globales para que cualquiera pueda elegir uno al registrar
        $models = AircraftModel::with('category')->get(); 
        
        return view('aircrafts.index', compact('aircrafts', 'models'));
    }

    /**
     * Guarda una nueva aeronave.
     */
    public function store(Request $request)
    {
        $request->validate([
            'registration' => 'required|max:20', // Quitamos 'unique:aircraft'
            'aircraft_model_id' => 'required|exists:aircraft_models,id',
        ]);

        $registration = strtoupper($request->registration);

        // LÓGICA DE UNICIDAD: Buscamos si ya existe o la creamos
        $aircraft = Aircraft::firstOrCreate(
            ['registration' => $registration],
            ['aircraft_model_id' => $request->aircraft_model_id, 'is_active' => true]
        );

        // LÓGICA DE ASOCIACIÓN: La vinculamos al usuario actual sin duplicar en la pivot
        auth()->user()->aircrafts()->syncWithoutDetaching([$aircraft->id]);

        return redirect()->back()->with('success', 'Aeronave añadida a su flota con éxito.');
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

        if ($aircraft->users()->count() > 0) {
            return redirect()->back()->with('error', 'No se puede eliminar: Hay pilotos que aún tienen esta aeronave en su flota.');
        }

        try {
            $aircraft->delete();
            return redirect()->back()->with('success', 'Aeronave eliminada del sistema.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se puede eliminar: esta aeronave ya tiene registros de vuelo.');
        }
    }

    /**
     * Para los pilotos: Quitar de su flota personal.
     */
    public function detach(Aircraft $aircraft)
    {
        auth()->user()->aircrafts()->detach($aircraft->id);
        return redirect()->back()->with('success', 'Aeronave quitada de su flota personal.');
    }
}
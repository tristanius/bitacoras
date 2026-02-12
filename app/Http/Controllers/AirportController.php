<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    public function index()
    {
        // Lógica Híbrida: Aeropuertos Públicos O los que el usuario tiene asociados (privados)
        $airports = Airport::where('is_public', true)
            ->orWhereHas('users', function($query) {
                $query->where('user_id', auth()->id());
            })->get();

        return view('airports.index', compact('airports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'icao_code' => 'required|max:5', // Quitamos 'unique:airports'
            'name'      => 'required|string|max:255',
            'is_public' => 'nullable|boolean',
        ]);

        $icao = strtoupper($request->icao_code);
        if($request->has('is_public')) {
            $request->is_public = true;
        }else{
            $request->is_public = false;
        }
        // 1. Buscar si existe o crear (por defecto is_public=false según acordamos)
        $airport = Airport::firstOrCreate(
            ['icao_code' => $icao],
            ['name' => $request->name, 'is_active' => true, 'is_public' => $request->is_public]
        );
    
        // 2. Vincular al usuario actual (si ya era público, el vínculo no sobra para su lista personal)
        if(!$request->is_public) {
            auth()->user()->airports()->syncWithoutDetaching([$airport->id]);
        }

        return redirect()->route('airports.index')->with('success', 'Aeropuerto gestionado con éxito.');
    }
    

    public function toggleStatus(Airport $airport)
    {
        // Cambiamos el estado de activo a inactivo y viceversa
        $airport->update(['is_active' => !$airport->is_active]);
        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    public function destroy(Airport $airport)
    {
        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('error', 'Solo el administrador puede eliminar registros globales.');
        }

        try {
            $airport->delete();
            return redirect()->back()->with('success', 'Aeropuerto eliminado del sistema.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se puede eliminar: tiene registros de vuelo relacionados.');
        }
    }

    public function detach(Airport $airport)
    {
        // Los pilotos solo "desvinculan" de su lista
        auth()->user()->airports()->detach($airport->id);
        return redirect()->back()->with('success', 'Aeropuerto quitado de su lista.');
    }
}
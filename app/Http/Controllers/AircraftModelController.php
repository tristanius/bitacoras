<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AircraftModel;
use App\Models\AircraftCategory;

class AircraftModelController extends Controller
{
    public function index()
    {
        $models = AircraftModel::with('category')->get();
        $categories = AircraftCategory::all(); 
        return view('aircraft_models.index', compact('models', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'aircraft_category_id' => 'required|exists:aircraft_categories,id',
        ]);

        AircraftModel::create($validated);

        return redirect()->route('aircraft_models.index')->with('success', 'Modelo creado con éxito.');
    }

    // ... Métodos update y destroy similares a los de Categorías
    public function update(Request $request, AircraftModel $aircraft_mod)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255,' . $aircraft_mod->id,
            'manufacturer' => 'required|string|max:255',
            'aircraft_category_id' => 'required|exists:aircraft_categories,id',
        ]);

        $aircraft_mod->update($validated);

        return redirect()->route('aircraft_models.index')
                        ->with('success', 'Modelo actualizado correctamente.');
    }

    public function destroy(AircraftCategory $aircraft_mod)
    {
        // Opcional: Validar si tiene modelos asociados antes de borrar
        $aircraft_mod->delete();

        return redirect()->route('aircraft_models.index')
                        ->with('success', 'Modelo eliminado con éxito.');
    }
}

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

    public function update(Request $request, AircraftModel $aircraftModel)
    {
        $validated = $request->validate([
            // Nota el cambio a 'unique:tabla,columna,id_a_ignorar'
            'name' => 'required|string|max:255|unique:aircraft_models,name,' . $aircraftModel->id,
            'manufacturer' => 'required|string|max:255',
            'aircraft_category_id' => 'required|exists:aircraft_categories,id',
        ]);

        $aircraftModel->update($validated);

        return redirect()->route('aircraft_models.index')
            ->with('success', 'Modelo actualizado correctamente.');
    }

    public function destroy(AircraftCategory $aircraftModel)
    {
        // Opcional: Validar si tiene modelos asociados antes de borrar
        $aircraftModel->delete();

        return redirect()->route('aircraft_models.index')
                        ->with('success', 'Modelo eliminado con éxito.');
    }
}

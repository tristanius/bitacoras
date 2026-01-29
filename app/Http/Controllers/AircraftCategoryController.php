<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AircraftCategory;

class AircraftCategoryController extends Controller
{
    public function index()
    {
        $categories = AircraftCategory::all();
        return view('aircraft_categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validamos la entrada
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:aircraft_categories,name',
            'description' => 'nullable|string|max:500',
        ], [
            // Mensajes personalizados para el Toast naranja de Koho
            'name.unique' => 'Esta categoría ya existe en el sistema.',
            'name.required' => 'El nombre de la categoría es obligatorio.',
        ]);

        // 2. Creamos el registro
        AircraftCategory::create($validated);

        // 3. Redireccionamos con mensaje de éxito (Toast verde)
        return redirect()->route('aircraft_categories.index')
                        ->with('success', 'Categoría técnica creada correctamente.');
    }

    public function update(Request $request, AircraftCategory $aircraft_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:aircraft_categories,name,' . $aircraft_category->id,
            'description' => 'nullable|string|max:500',
        ]);

        $aircraft_category->update($validated);

        return redirect()->route('aircraft_categories.index')
                        ->with('success', 'Categoría actualizada correctamente.');
    }

    public function destroy(AircraftCategory $aircraft_category)
    {
        // Opcional: Validar si tiene modelos asociados antes de borrar
        $aircraft_category->delete();

        return redirect()->route('aircraft_categories.index')
                        ->with('success', 'Categoría eliminada con éxito.');
    }
}

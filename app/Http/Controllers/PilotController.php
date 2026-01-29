<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PilotController extends Controller
{
    public function index()
    {
        // Solo traemos a los usuarios que tengan el rol de 'Piloto' o 'Instructor'
        $pilots = User::role(['Piloto', 'Instructor'])->get();
        return view('pilots.index', compact('pilots'));
    }

    public function toggleStatus(\App\Models\User $pilot)
    {
        // Cambiamos el estado de activo a inactivo y viceversa
        $pilot->update(['is_active' => !$pilot->is_active]);
        return redirect()->back()->with('success', 'Estado actualizado.');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'doc_number' => 'required|unique:users,doc_number',
            'doc_type'   => 'required|string|max:25', // CAMBIADO: Antes decía 'email'
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'license_number' => 'required|unique:users,license_number',
            'medical_certificate_expiry' => 'required|date',
            'phone'      => 'nullable|string',
        ]);

        $user = \App\Models\User::create([
            'doc_number'=> $validated['doc_number'],
            'doc_type'=> $validated['doc_type'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'license_number' => $validated['license_number'],
            'medical_certificate_expiry' => $validated['medical_certificate_expiry'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['license_number']), // Password inicial = Licencia
        ]);

        $user->assignRole('Piloto');

        return redirect()->back()->with('success', 'Piloto creado con éxito. Su clave es su licencia.');
    }

    public function update(Request $request, \App\Models\User $pilot)
    {
        $validated = $request->validate([
            'doc_number' => 'required|unique:users,doc_number,' . $pilot->id,
            'doc_type' => 'required|string|max:25,' . $pilot->id,
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $pilot->id,
            'license_number' => 'required|unique:users,license_number,' . $pilot->id,
            'medical_certificate_expiry' => 'required|date',
            'phone' => 'nullable|string',
        ]);

        $pilot->update($validated);

        return redirect()->back()->with('success', 'Datos del piloto actualizados.');
    }

    public function destroy(\App\Models\User $pilot)
    {
        // Verificación de seguridad para el Admin
        if (!auth()->user()->hasRole('Admin')) {
            return redirect()->back()->with('error', 'No tienes permiso para eliminar pilotos.');
        }
        // Opcional: Podrías validar que el piloto no tenga bitácoras asociadas antes de borrar
        
        try {
            $pilot->delete();
            return redirect()->route('pilots.index')->with('success', 'Piloto eliminado correctamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se puede eliminar: este piloto ya tiene registros de vuelo.');
        }
    }
}

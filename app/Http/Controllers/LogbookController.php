<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogbookController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        \App\Models\Logbook::create([
            'name' => $request->name,
            'user_id' => auth()->id(), // El logbook pertenece al usuario autenticado
        ]);

        return redirect()->back()->with('success', 'Bitácora creada correctamente.');
    }
}

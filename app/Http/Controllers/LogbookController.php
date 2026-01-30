<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Logbook;

class LogbookController extends Controller
{
    // Muestra todas las carpetas/bitácoras del usuario
    public function index()
    {
        $logbooks = Logbook::where('user_id', auth()->id())
            ->withCount('logEntries') // Para mostrar cuántos vuelos tiene cada una
            ->get();

        return view('logbooks.index', compact('logbooks'));
    }

    public function create()
    {
        return view('logbooks.create');
    }

    // Muestra el contenido de una bitácora específica
    public function show(Logbook $logbook)
    {
        // Cargamos las entradas de vuelo relacionadas
        $entries = $logbook->logEntries()->orderBy('date', 'desc')->get();
        return view('logbooks.show', compact('logbook', 'entries'));
    }
    // crear guardar
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
        ]);

        \App\Models\Logbook::create([
            'name' => $request->name,
            'date' => $request->date,            
            'user_id' => auth()->id(), // El logbook pertenece al usuario autenticado
        ]);

        return redirect()->back()->with('success', 'Bitácora creada correctamente.');
    }
}

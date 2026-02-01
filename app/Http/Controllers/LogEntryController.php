<?php

namespace App\Http\Controllers;

use App\Models\logentry;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Models\Aircraft;
use \App\Models\Airport;
use \App\Models\User;

class LogEntryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = LogEntry::where('is_active', true);

        // Si es Admin u Oficial, ven TODO
        if ($user->hasAnyRole(['admin', 'oficial'])) {
            $entries = $query->orderBy('date', 'desc')->get();
        } 
        // Si es Instructor, ve los suyos y los que debe validar
        elseif ($user->hasRole('instructor')) {
            $entries = $query->where('pilot_id', $user->id)
                            ->orWhere('instructor_id', $user->id)
                            ->orderBy('date', 'desc')->get();
        } 
        // Si es Piloto, solo lo suyo
        else {
            $entries = $query->where('pilot_id', $user->id)
                            ->orderBy('date', 'desc')->get();
        }
        $totalEntries = $entries->count();
        $totalHours = $entries->sum('total_time'); 

        return view('log_entries.index', compact('entries', 'totalEntries', 'totalHours'));
    }

    public function create()
    {
        $aircrafts = Aircraft::where('is_active', true)->get();
        $airports = Airport::where('is_active', true)->get();
        // Solo usuarios que sean pilotos o instructores activos
        $instructors = User::role('Instructor')->where('is_active', true)->get();

        return view('log_entries.create', compact('aircrafts', 'airports', 'instructors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logbook_id' => 'required|exists:logbooks,id',
            'aircraft_id' => 'required|exists:aircraft,id',
            'origin_id' => 'required|exists:airports,id',
            'destination_id' => 'required|exists:airports,id',
            'date' => 'required|date',
            'hobbs_out' => 'required|numeric',
            'hobbs_in' => 'required|numeric',
            'total_time' => 'required|numeric',
            'pic_time' => 'nullable|numeric',
            'sic_time' => 'nullable|numeric',
            'solo_time' => 'nullable|numeric',
            'dual_time' => 'nullable|numeric',
            'cfi_time' => 'nullable|numeric',
            'simulator_time' => 'nullable|numeric',
            'xc_time' => 'nullable|numeric',
            'night_time' => 'nullable|numeric',
            'instr_actual' => 'nullable|numeric',
            'instr_sim' => 'nullable|numeric',
            'approaches' => 'nullable|integer',
            'landings_day' => 'nullable|integer',
            'landings_night' => 'nullable|integer',
            'instructor_id' => 'nullable|exists:users,id',
            'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240'
        ]);

        return DB::transaction(function () use ($request) {
            $entry = logentry::create($request->all());

            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('attachments', 'public');

                    $entry->attachments()->create([
                        'name' => $file->getClientOriginalName(),
                        'path' => $path,
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Registro completado.');
        });
    }

    public function edit(LogEntry $logEntry)
    {
        $user = auth()->user();

        // SEGURIDAD: Solo el piloto dueño o el instructor asignado pueden editar
        if ($logEntry->user_id !== $user->id && $logEntry->instructor_id !== $user->id) {
            abort(403, 'No tiene permiso para editar este registro.');
        }

        // Cargamos solo los datos activos para los selectores
        $aircrafts = Aircraft::where('is_active', true)->get();
        $airports = Airport::where('is_active', true)->get();
        
        // Obtenemos usuarios con rol de instructor para el select
        $instructors = User::role('instructor')->where('is_active', true)->get();

        return view('log_entries.edit', compact('logEntry', 'aircrafts', 'airports', 'instructors'));
    }

    public function update(Request $request, LogEntry $logEntry)
    {
        // 1. Validar datos básicos
        $request->validate([
            'aircraft_id' => 'required',
            'origin_id' => 'required',
            'destination_id' => 'required',
            'date' => 'required|date',
        ]);

        // 2. Lógica especial de Validación (El "OK" del instructor)
        if (auth()->user()->hasRole('instructor') && $request->has('approve')) {
            $logEntry->validated = true;
        }

        // 3. Actualizar el resto de campos
        $logEntry->update($request->all());

        return redirect()->route('log_entries.index')->with('success', 'Registro actualizado correctamente.');
    }

    public function destroy(LogEntry $logEntry)
    {
        // Solo desactivamos, no borramos de la DB
        $logEntry->update(['is_active' => false]);
        
        return redirect()->route('log_entries.index')->with('warning', 'El registro ha sido anulado.');
    }


    public function validateEntry(LogEntry $logEntry)
    {
        // Seguridad: Solo el instructor asignado puede dar el OK
        if (auth()->id() !== $logEntry->instructor_id) {
            abort(403);
        }

        $logEntry->update(['validated' => true]);
        return back()->with('success', 'Vuelo validado correctamente.');
    }
}
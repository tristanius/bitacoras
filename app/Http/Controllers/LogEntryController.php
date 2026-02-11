<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Models\Aircraft;
use \App\Models\Airport;
use \App\Models\User;
use App\Models\LogEntry;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Carbon\Carbon;


class LogEntryController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        #$query = LogEntry::where('is_active', true);
        $query = LogEntry::with(['aircraft', 'pilot', 'instructor']);
        $entries = null;
        $sums = null;

        // Si es Admin u Oficial, ven TODO
        if ($user->hasRole('Admin')) {
            $entries = $query->orderBy('date', 'desc')->latest()->paginate(100);
        } 
        // Si es Instructor, ve los suyos y los que debe validar
        elseif ($user->hasRole('Instructor')) {
            $entries = $query->where('pilot_id', $user->id)
                            ->orWhere('instructor_id', $user->id)
                            ->where('is_active',true)
                            ->orderBy('date', 'desc')->latest()->paginate(100);
        } 
        elseif ($user->hasRole( 'Oficial de Operaciones')) {
            $entries = $query->where('is_active',true)->orderBy('date', 'desc')->latest()->paginate(100);
        }
        else {
            $entries = $query->where('pilot_id', $user->id)
                            ->orderBy('date', 'desc')->latest()->paginate(100);
            $sums = $query->where('pilot_id', $user->id)
                            ->orderBy('date', 'desc')
                            ->where('is_active',true)
                            ->get();
        }
        $totalEntries = $entries->count();
        $totalHours = isset($sums)? $sums->sum('total_time'): $entries->sum('total_time'); 

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
            $data = $request->all();
            $data['pilot_id'] = auth()->id();
            $entry = LogEntry::create($data);

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

            return redirect()->route('log_entries.index')->with('success', 'Registro completado.');
        });
    }

    public function show(LogEntry $log_entry)
    {
        // Cargamos las relaciones para ver quién voló y en qué avión
        $log_entry->load(['pilot', 'aircraft', 'instructor', 'origin', 'destination','attachments']);
        return view('log_entries.show', compact('log_entry'));
    }

    public function edit(LogEntry $logEntry)
    {
        $user = auth()->user();

        // SEGURIDAD: Solo el piloto dueño o el instructor asignado pueden editar
        if ($logEntry->pilot_id !== $user->id && $logEntry->instructor_id !== $user->id) {
            abort(403, 'No tiene permiso para editar este registro.'. $user->id .'!= '.$logEntry->user_id .' - '.$logEntry->instructor_id);
        }

        // Cargamos solo los datos activos para los selectores
        $aircrafts = Aircraft::where('is_active', true)->get();
        $airports = Airport::where('is_active', true)->get();
        $instructors = User::role('Instructor')->where('is_active', true)->get();
        
        // Obtenemos usuarios con rol de instructor para el select
        $instructors = User::role('instructor')->where('is_active', true)->get();

        return view('log_entries.edit', compact('logEntry', 'aircrafts', 'airports', 'instructors'));
    }

    public function update(Request $request, LogEntry $logEntry)
    {
        
        $request->validate([
            'aircraft_id' => 'required',
            'origin_id' => 'required',
            'destination_id' => 'required',
            'date' => 'required|date',
        ]);
        if (auth()->user()->hasRole('instructor') && $request->has('approve')) {
            $logEntry->validated = true;
        }
        return DB::transaction(function () use ($request, $logEntry) {
            $logEntry->update($request->all());
            if ($request->hasFile('files')) {
                foreach ($request->file('files') as $file) {
                    $path = $file->store('attachments', 'public');
                    $logEntry->attachments()->create([
                        'name'      => $file->getClientOriginalName(),
                        'path'      => $path,
                        'mime_type' => $file->getMimeType(),
                    ]);
                }
            }

            return redirect()->route('log_entries.index')
                            ->with('success', 'Registro y archivos actualizados con éxito.');
        });
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
            #abort(403);
            return back()->with('error', 'No tienes permiso para validar este vuelo.');
        }

        $logEntry->update(['validated' => true]);
        return back()->with('success', 'Vuelo validado correctamente.');
    }

    //----------------- Reportes y consultas ---------------------------
    public function reports(Request $request)
    {
        $user = auth()->user();
        
        // 1. Cargamos los selectores para los filtros
        $aircrafts = Aircraft::where('is_active', true)->get();
        $airports = Airport::all();
        
        // Lógica de selección de Pilotos según Rol
        if ($user->hasAnyRole(['Admin', 'Oficial de Operaciones'])) {
            $pilots = User::role('piloto')->get(); // O el rol que manejes
        } else {
            $pilots = collect([$user]); // El piloto solo se ve a sí mismo
        }

        // 2. Construcción de la Query
        $query = LogEntry::with(['pilot', 'aircraft', 'origin', 'destination']);

        // Filtros dinámicos
        if ($request->filled('pilot_id')) {
            $query->where('pilot_id', $user->hasAnyRole(['Admin', 'Oficial de Operaciones']) ? $request->pilot_id : $user->id);
        } elseif (!$user->hasAnyRole(['Admin', 'Oficial de Operaciones'])) {
            $query->where('pilot_id', $user->id);
        }

        if ($request->filled('aircraft_id')) $query->where('aircraft_id', $request->aircraft_id);
        if ($request->filled('origin_id')) $query->where('origin_id', $request->origin_id);
        if ($request->filled('destination_id')) $query->where('destination_id', $request->destination_id);
        if ($request->filled('date_from')) $query->where('date', '>=', $request->date_from);
        if ($request->filled('date_to')) $query->where('date', '<=', $request->date_to);

        $entries = $query->latest('date')->paginate(20);

        return view('log_entries.reports', compact('entries', 'aircrafts', 'airports', 'pilots'));
    }

    public function exportCsv(Request $request)
    {
        $user = auth()->user();

        // 1. Definir el nombre del archivo con la fecha actual
        $fileName = 'Reporte_Bitacoras_' . Carbon::now()->format('Y-m-d_His') . '.csv';

        // 2. Construir la consulta base con relaciones (Eager Loading)
        $query = LogEntry::with(['pilot', 'aircraft', 'origin', 'destination', 'instructor'])
                        ->where('is_active', true);

        // 3. Aplicar Filtros Dinámicos (Idénticos a la vista de reportes)
        if ($request->filled('pilot_id')) {
            // Si no es admin/oficial, solo puede filtrar su propio ID
            $idAFiltrar = $user->hasAnyRole(['admin', 'oficial']) ? $request->pilot_id : $user->id;
            $query->where('pilot_id', $idAFiltrar);
        } elseif (!$user->hasAnyRole(['admin', 'oficial'])) {
            // Seguridad: Si un piloto intenta exportar sin filtro, forzar su ID
            $query->where('pilot_id', $user->id);
        }

        if ($request->filled('aircraft_id')) {
            $query->where('aircraft_id', $request->aircraft_id);
        }
        if ($request->filled('origin_id')) {
            $query->where('origin_id', $request->origin_id);
        }
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->destination_id);
        }
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        // 4. Preparar los headers del archivo
        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        // 5. Definir las columnas del CSV (Campos completos)
        $columns = [
            'ID', 'Fecha', 'Piloto', 'Aeronave', 'Clase', 'Modelo', 'Origen', 'Destino', 
            'Hobbs Out', 'Hobbs In', 'Total Time', 
            'PIC', 'SIC', 'Solo', 'Dual', 'CFI', 'XC', 'Night', 
            'Instr Actual', 'Instr Sim', 'Simulator', 
            'Landings Day', 'Landings Night', 'Approaches', 'Holds', 
            'Instructor', 'Validado', 'Observaciones'
        ];

        // 6. Generar el Stream
        $callback = function() use($query, $columns) {
            $file = fopen('php://output', 'w');
            
            // Añadir el BOM para que Excel reconozca caracteres especiales (tildes, Ñ)
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Escribir encabezados
            fputcsv($file, $columns, ';');

            // Procesar los datos en bloques (chunks) para no saturar la RAM
            $query->chunk(200, function($entries) use($file) {
                foreach ($entries as $entry) {
                    fputcsv($file, [
                        $entry->id,
                        $entry->date,
                        $entry->pilot->name ?? 'N/A',
                        $entry->aircraft->registration ?? 'N/A',
                        $entry->aircraft->model->name ?? 'N/A',
                        $entry->aircraft->model->category->name ?? 'N/A',
                        $entry->origin->icao_code ?? 'N/A',
                        $entry->destination->icao_code ?? 'N/A',
                        $entry->hobbs_out,
                        $entry->hobbs_in,
                        $entry->total_time,
                        $entry->pic_time,
                        $entry->sic_time,
                        $entry->solo_time,
                        $entry->dual_time,
                        $entry->cfi_time,
                        $entry->xc_time,
                        $entry->night_time,
                        $entry->instr_actual,
                        $entry->instr_sim,
                        $entry->simulator_time,
                        $entry->landings_day,
                        $entry->landings_night,
                        $entry->approaches,
                        $entry->holds,
                        $entry->instructor->name ?? 'N/A',
                        $entry->validated ? 'SI' : 'NO',
                        $entry->remarks
                    ], ';');
                }
            });

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
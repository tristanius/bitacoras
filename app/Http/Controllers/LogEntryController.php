<?php

namespace App\Http\Controllers;

use App\Models\logentry;
use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Models\Aircraft;
use \App\Models\Airport;

class LogEntryController extends Controller
{
    public function create()
    {
        // Traemos los datos para llenar los selects
        $logbooks = \App\Models\logbook::where('user_id', auth()->id())->get();
        $aircrafts = Aircraft::where('is_active', true)->get();
        $airports = Airport::where('is_active', true)->get();
        $pilots = \App\Models\User::select('id', 'name')->orderBy('name')->get();

        return view('log_entries.create', compact('logbooks', 'aircrafts', 'airports', 'pilots'));
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
}
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use App\Models\User;
use App\Models\Aircraft;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    // Añade esto a tu ReportController.php

    public function index()
    {
        // Solo permitimos que Admin y Oficial vean esta página de descargas masivas
        if (!auth()->user()->hasAnyRole(['Admin', 'Oficial de Operaciones','Piloto','Instructor'])) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        $pilots = User::role('piloto')->where('is_active', true)->get();
        $aircrafts = Aircraft::where('is_active', true)->get();

        return view('reports.index', compact('pilots', 'aircrafts'));
    }
    /**
     * Reporte para Piloto
     */
    public function downloadPilotLogbook(Request $request)
    {
        $request->validate([
            'pilot_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $pilot = User::findOrFail($request->pilot_id);
        $entries = LogEntry::with(['aircraft', 'origin', 'destination'])
            ->where('pilot_id', $pilot->id)
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->where('is_active', true)
            ->orderBy('date', 'asc')
            ->get();

        $pdf = Pdf::loadView('reports.pilot_logbook_pdf', compact('entries', 'pilot', 'request'))
                  ->setPaper('letter', 'landscape'); // Formato horizontal

        return $pdf->download("Logbook_Piloto_{$pilot->name}.pdf");
    }

    /**
     * Reporte para Avión
     */
    public function downloadAircraftLogbook(Request $request)
    {
        $request->validate([
            'aircraft_id' => 'required|exists:aircraft,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
        ]);

        $aircraft = Aircraft::findOrFail($request->aircraft_id);
        $entries = LogEntry::with(['pilot', 'origin', 'destination'])
            ->where('aircraft_id', $aircraft->id)
            ->whereBetween('date', [$request->start_date, $request->end_date])
            ->where('is_active', true)
            ->orderBy('date', 'asc')
            ->get();

        $pdf = Pdf::loadView('reports.aircraft_logbook_pdf', compact('entries', 'aircraft', 'request'))
                  ->setPaper('letter', 'landscape');

        return $pdf->download("Logbook_Avion_{$aircraft->registration}.pdf");
    }
}
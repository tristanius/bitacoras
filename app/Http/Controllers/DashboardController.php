<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogEntry;
use App\Models\Aircraft;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        // 1. Estadísticas Rápidas (Cards)
        $stats = [
            'total_hours' => LogEntry::where('is_active', true)
                ->where('pilot_id', $user->id)
                ->sum('total_time'),
            'flights_month' => LogEntry::where('is_active', true)
                ->where('pilot_id', $user->id)
                                ->whereMonth('date', Carbon::now()->month)->count(),
            'active_aircraft' => Aircraft::where('is_active', true)->count(),
            'pending_validations' => LogEntry::where('is_active', true)->where('pilot_id', $user->id)
                                    ->where('validated', false)->count(),
        ];

        // 2. Gráfico 1: Horas por Mes (Últimos 6 meses)
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $monthlyLabels[] = $month->translatedFormat('M Y');
            $monthlyData[] = LogEntry::where('is_active', true)
                            ->where('pilot_id', $user->id)
                            ->whereMonth('date', $month->month)
                            ->whereYear('date', $month->year)
                            ->sum('total_time');
        }

        // 3. Gráfico 2: Horas Totales por Aeronave (Top 5)
        $aircraftStats = LogEntry::with('aircraft')
            ->select('aircraft_id', DB::raw('SUM(total_time) as total'))
            ->where('pilot_id', $user->id)
            ->groupBy('aircraft_id')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $aircraftLabels = $aircraftStats->pluck('aircraft.registration');
        $aircraftData = $aircraftStats->pluck('total');
        
        // 1. Estadísticas del Perfil (específicas del usuario)
        $userStats = [
            'my_total_hours' => LogEntry::where('pilot_id', $user->id)->where('is_active', true)->where('pilot_id', $user->id)->sum('total_time'),
            'my_last_flight' => LogEntry::where('pilot_id', $user->id)->where('is_active', true)->latest('date')->first(),
            'role' => $user->getRoleNames()->first() ?? 'Sin Rol',
        ];

        // 2. Estadísticas Globales (lo que ya tenías)
        $stats = [
            'total_hours' => LogEntry::where('is_active', true)
                ->where('pilot_id', $user->id)
                ->sum('total_time'),
            'flights_month' => LogEntry::where('is_active', true)
                ->where('pilot_id', $user->id)
                ->whereMonth('date', now()->month)->count(),
            'active_aircraft' => Aircraft::where('is_active', true)->count(),
            'pending_validations' => LogEntry::where('is_active', true)
                ->where('pilot_id', $user->id)
                ->where('validated', false)->count(),
        ];

        // 3. Actividad Reciente (Últimos 5 movimientos)
        $recentActivity = LogEntry::with(['pilot', 'aircraft', 'destination'])
            ->where('is_active', true)
            ->where('pilot_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // 4. Gráfico Nuevo: Top 5 Aeropuertos de Destino
        $topDestinations = LogEntry::join('airports', 'log_entries.destination_id', '=', 'airports.id')
            ->select('airports.icao_code', DB::raw('count(*) as total'))
            ->where('pilot_id', $user->id)
            ->groupBy('airports.icao_code')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $destLabels = $topDestinations->pluck('icao_code');
        $destData = $topDestinations->pluck('total');

        // Mantenemos tus datos de gráficas anteriores...
        // (monthlyLabels, monthlyData, aircraftLabels, aircraftData)

        return view('dashboard', compact(
            'user', 'userStats', 'stats', 'recentActivity', 
            'destLabels', 'destData', 
            'monthlyLabels', 'monthlyData', 'aircraftLabels', 'aircraftData'
        ));
    }
}
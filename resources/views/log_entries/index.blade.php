@extends('layouts.admin')

@section('content')
<hr>
<div class="container-fluid">
    {{-- CABECERA: Perfil y Estadísticas (Según su mockup) --}}
    <div class="row">
        <div class="col-sm-12">
            <div class="card profile-header shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        {{-- Foto de Usuario --}}
                        <div class="flex-shrink-0">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/'.auth()->user()->photo) }}" class="rounded-circle" style="width: 100px; height: 100px; border: 3px solid white;">
                            @else
                                <div class="rounded-circle bg-light text-primary d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; border: 3px solid white;">
                                    <h2 class="mb-0 fw-bold">{{ substr(auth()->user()->name, 0, 1) }}</h2>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Información del Piloto --}}
                        <div class="flex-grow-1 ms-4">
                            <h3 class="fw-bold mb-1" style="font-family: 'Montserrat', sans-serif;">{{ auth()->user()->name }}</h3>
                            <p class="mb-2 text-uppercase badge bg-light text-primary">{{ auth()->user()->getRoleNames()->first() }}</p>
                            <div class="row">
                                <div class="col-auto">
                                    <small class="d-block opacity-75"># de LogEntries</small>
                                    <span class="h5 fw-bold">{{ $totalEntries }}</span>
                                </div>
                                <div class="col-auto ms-4 border-start ps-4">
                                    <small class="d-block opacity-75"># Horas Totales Registradas</small>
                                    <span class="h5 fw-bold">{{ number_format($totalHours, 1) }} hrs</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BOTÓN DE ACCIÓN --}}
    <div class="row mb-3">
        <div class="col-12 text-end">
            <a href="{{ route('log_entries.create') }}" class="btn btn-primary shadow-sm fw-bold">
                <i class="fa fa-plus-circle"></i> + LogEntry
            </a>
        </div>
    </div>

    {{-- DATATABLE DE REGISTROS --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="logTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Matrícula</th>
                            <th>Ruta (Origen/Destino)</th>
                            <th>Instructor</th>
                            <th>Total Horas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }}</td>
                            <td class="fw-bold text-primary">{{ $entry->aircraft->registration }}</td>
                            <td>{{ $entry->origin }} ✈️ {{ $entry->destination }}</td>
                            <td>{{ $entry->instructor->name ?? 'N/A' }}</td>
                            <td class="fw-bold">{{ $entry->total_time }}</td>
                            <td>
                                @if($entry->validated)
                                    <span class="badge bg-success"><i class="fa fa-check"></i> VALIDADO</span>
                                @else
                                    <span class="badge bg-warning text-dark"><i class="fa fa-clock-o"></i> PENDIENTE</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('log_entries.edit', $entry->id) }}" class="btn btn-xs btn-outline-info"><i class="fa fa-edit"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Script para inicializar DataTables --}}
<script>
    $(document).ready(function() {
        $('#logTable').DataTable({
            "language": { "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" },
            "order": [[ 0, "desc" ]] // Ordenar por fecha descendente
        });
    });
</script>
@endsection
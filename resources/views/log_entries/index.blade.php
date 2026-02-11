@extends('layouts.admin')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
@endsection

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
                            @hasanyrole('Piloto|Instructor')
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
                            @endhasanyrole 
                            @hasanyrole('Admin|Oficial de Operaciones')
                            <div class="row">
                                <div class="col-auto">
                                    <small class="d-block opacity-75"># de LogEntries</small>
                                    <span class="h5 fw-bold">{{ $totalEntries }}</span>
                                </div>
                                <div class="col-auto ms-4 border-start ps-4">
                                    <small class="d-block opacity-75"># Horas Totales Registradas</small>
                                    <span class="h5 fw-bold">Debe ir a Bitacoras > consultas pues su rol no permite ver este dato.</span>
                                </div>
                            </div>
                            @endhasanyrole 
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
            <div class="alert alert-light" role="alert">
                Se cargaran automaticamente los ultimos 100 registros creados (por fecha de creación) para cargar registros de fechas especificas ir a las consultas en Bitacoras > consultas.
            </div>
            <div class="table-responsive">
                <table id="logTable" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Matrícula <br> aeronave</th>
                            <th>Piloto</th>
                            <th>Ruta (Origen/Destino)</th>
                            <th>Instructor</th>
                            <th>Total Horas</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                        <tr @if(!$entry->is_active) style="background-color: #f8d7da; opacity: 0.7;" @endif>
                            <td>{{ \Carbon\Carbon::parse($entry->date)->format('d/m/Y') }} @if(!$entry->is_active) (Deshabilitado) @endif</td>
                            <td class="fw-bold text-primary">{{ $entry->aircraft->registration }}</td>
                            <td>{{ $entry->pilot->name }}</td>
                            <td>{{ $entry->origin->icao_code }} ✈️ {{ $entry->destination->icao_code }}</td>
                            <td>{{ $entry->instructor->name ?? 'N/A' }}</td>
                            <td class="fw-bold">{{ $entry->total_time }}</td>
                            <td>
                                @if( isset($entry->instructor_id) )
                                    @if($entry->validated)
                                        <span class="badge bg-success"><i class="fa fa-check"></i> VALIDADO</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="fa fa-clock-o"></i> PENDIENTE</span>
                                    @endif
                                @else
                                    <span>N/A</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('log_entries.show', $entry->id) }}" class="btn btn-xs btn-outline-primary"><i class="fa fa-eye"></i></a>
                                @if($entry->is_active)
                                @if( (isset($entry->instructor->id) && $entry->instructor->id === auth()->user()->id ) || $entry->pilot->id === auth()->user()->id )
                                <a href="{{ route('log_entries.edit', $entry->id) }}" class="btn btn-xs btn-outline-info"><i class="fa fa-edit"></i></a>
                                
                                {{-- Botón de Deshabilitar --}}
                                <form action="{{ route('log_entries.destroy', $entry->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Está seguro de deshabilitar este registro?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-xs btn-danger" title="Deshabilitar">
                                        <i class="fa fa-trash-o"></i>
                                    </button>
                                </form>
                                @endif
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{-- Esto genera los botones de página automáticamente --}}
        {{ $entries->links() }}
    </div>
</div>
@endsection

{{-- Script para inicializar DataTables --}}

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#logTable').DataTable({
            "language": { "url": "https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json" },
            "order": [[ 0, "desc" ]] // Ordenar por fecha descendente
        });
    });
</script>
@endpush
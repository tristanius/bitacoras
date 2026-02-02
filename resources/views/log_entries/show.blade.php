@extends('layouts.admin')

@section('content')
@include('partials.alerts')
@include('partials.monserrat_font')

<div class="container-fluid">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Detalle de Bitácora: Vuelo #{{ $log_entry->id }}</h4>
        <div class="page-title-right">
            <a href="{{ route('log_entries.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fa fa-arrow-left"></i> Volver al Listado
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-none border">
                <div class="card-body text-center">
                    <div class="avatar-md mb-3 mx-auto">
                        @if($log_entry->pilot->photo)
                            <img src="{{ asset('storage/'.$log_entry->pilot->photo) }}" class="rounded-circle img-thumbnail" style="width: 100px; height: 100px;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 100px; height: 100px;">
                                <h1 class="mb-0">{{ substr($log_entry->pilot->name, 0, 1) }}</h1>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $log_entry->pilot->name }}</h5>
                    <p class="text-muted text-uppercase small fw-bold">Piloto al Mando (PIC)</p>
                    
                    <hr>
                    
                    <div class="row text-start mt-4">
                        <div class="col-6 mb-3">
                            <label class="text-muted small d-block">Aeronave</label>
                            <span class="fw-bold text-primary">{{ $log_entry->aircraft->registration }}</span>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="text-muted small d-block">Fecha de Vuelo</label>
                            <span class="fw-bold">{{ \Carbon\Carbon::parse($log_entry->date)->format('d/m/Y') }}</span>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small d-block">Instructor Asignado</label>
                            <span class="fw-bold">{{ $log_entry->instructor->name ?? 'Vuelo Solo / Sin Instructor' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card bg-dark text-white shadow-none">
                <div class="card-body">
                    <h5 class="card-title text-white">Contadores Hobbs</h5>
                    <hr class="border-light">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Hobbs Salida:</span>
                        <span class="fw-bold text-info">{{ number_format($log_entry->hobbs_out, 1) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Hobbs Entrada:</span>
                        <span class="fw-bold text-info">{{ number_format($log_entry->hobbs_in, 1) }}</span>
                    </div>
                    <div class="alert alert-light py-2 text-center text-dark fw-bold mb-0 mt-3">
                        TOTAL TIEMPO: {{ number_format($log_entry->total_time, 2) }} hrs
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-none border">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="card-title mb-0">Detalles de la Misión</h5>
                        @if($log_entry->validated)
                            <span class="badge bg-success p-2 px-3"><i class="fa fa-check-circle"></i> VUELO VALIDADO</span>
                        @else
                            <span class="badge bg-warning text-dark p-2 px-3"><i class="fa fa-clock-o"></i> PENDIENTE DE VALIDACIÓN</span>
                        @endif
                    </div>

                    <div class="row text-center mb-4">
                        <div class="col-md-5">
                            <h2 class="mb-0 text-primary">{{ $log_entry->origin->icao_code }}</h2>
                            <small class="text-muted">{{ $log_entry->origin->name }}</small>
                        </div>
                        <div class="col-md-2 d-flex align-items-center justify-content-center">
                            <i class="fa fa-plane fa-2x text-muted"></i>
                        </div>
                        <div class="col-md-5">
                            <h2 class="mb-0 text-primary">{{ $log_entry->destination->icao_code }}</h2>
                            <small class="text-muted">{{ $log_entry->destination->name }}</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-none border">
                <div class="card-body">
                    <h5 class="card-title mb-4">Distribución de Tiempos y Condiciones</h5>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>PIC</th><th>SIC</th><th>Solo</th><th>Dual</th><th>CFI</th><th>Sim</th><th>Night</th><th>XC</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $log_entry->pic_time }}</td><td>{{ $log_entry->sic_time }}</td>
                                    <td>{{ $log_entry->solo_time }}</td><td>{{ $log_entry->dual_time }}</td>
                                    <td>{{ $log_entry->cfi_time }}</td><td>{{ $log_entry->simulator_time }}</td>
                                    <td>{{ $log_entry->night_time }}</td><td>{{ $log_entry->xc_time }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-none border h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Observaciones / Remarks</h5>
                            <p class="text-muted italic">"{{ $log_entry->remarks ?? 'Sin observaciones adicionales.' }}"</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-none border h-100">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Anexos / Evidencias</h5>
                            <ul class="list-unstyled">
                                @forelse($log_entry->attachments as $file)
                                    <li class="mb-2">
                                        <i class="fa fa-file-pdf-o text-danger"></i> 
                                        <a href="{{ asset('storage/'.$file->path) }}" target="_blank" class="text-decoration-none">
                                            {{ $file->name }}
                                        </a>
                                    </li>
                                @empty
                                    <li class="text-muted">No se adjuntaron archivos.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            @if(!$log_entry->validated && auth()->id() == $log_entry->instructor_id)
                <div class="card border-primary mt-4 bg-light">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="text-primary mb-1">Confirmación de Instrucción</h5>
                            <p class="mb-0 small">Como instructor asignado, certifique que los datos anteriores son veraces.</p>
                        </div>
                        <form action="{{ route('log_entries.validate', $log_entry->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success p-3 fw-bold shadow">
                                <i class="fa fa-check"></i> DAR EL OK / VALIDAR VUELO
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
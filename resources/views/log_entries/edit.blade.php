@extends('layouts.admin')

@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<br>
<div class="container-fluid">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Editar Registro de Vuelo (Log Entry) #{{ $logEntry->id }}</h4>
    </div>

    {{-- IMPORTANTE: Cambiamos a la ruta UPDATE y agregamos el ID --}}
    <form action="{{ route('log_entries.update', $logEntry->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Requerido para actualizaciones en Laravel --}}

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-4">1. Datos de la Misión</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Fecha</label>
                                <input type="date" name="date" class="form-control" value="{{ old('date', $logEntry->date) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Aeronave</label>
                                <select name="aircraft_id" class="form-select" required>
                                    @foreach($aircrafts as $aircraft)
                                        <option value="{{ $aircraft->id }}" {{ old('aircraft_id', $logEntry->aircraft_id) == $aircraft->id ? 'selected' : '' }}> 
                                            {{ $aircraft->registration }} - {{ $aircraft->model->name ?? 'N/A' }} 
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Instructor (Opcional)</label>
                                <select name="instructor_id" class="form-select select2-instructor">
                                    <option value="">-- Vuelo Solo --</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}" {{ old('instructor_id', $logEntry->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                            {{ $instructor->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6 mb-3">
                                <label>Origen</label>
                                <select name="origin_id" class="form-select" required>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('origin_id', $logEntry->origin_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->icao_code }} - {{ $airport->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Destino</label>
                                <select name="destination_id" class="form-select" required>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" {{ old('destination_id', $logEntry->destination_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->icao_code }} - {{ $airport->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN HOBBS --}}
                <div class="card shadow-none border bg-dark text-white shadow-none">
                    <div class="card-body">
                        <h5 class="card-title mb-3">2. Cómputo de Tiempo (Hobbs)</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Hobbs Salida (Out)</label>
                                <input type="number" step="0.1" name="hobbs_out" id="hobbs_out" class="form-control form-control-lg text-primary" value="{{ old('hobbs_out', $logEntry->hobbs_out) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Hobbs Entrada (In)</label>
                                <input type="number" step="0.1" name="hobbs_in" id="hobbs_in" class="form-control form-control-lg text-success" value="{{ old('hobbs_in', $logEntry->hobbs_in) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SECCIÓN TIEMPOS DETALLADOS --}}
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-3">3. Tiempos Detallados (Hrs)</h5>
                        <div class="row">
                            @php
                                $tiempos = ['pic_time' => 'PIC', 'sic_time' => 'SIC', 'solo_time' => 'Solo', 'dual_time' => 'Dual Received', 'cfi_time' => 'As CFI', 'xc_time' => 'Cross Country', 'night_time' => 'Night'];
                            @endphp
                            @foreach($tiempos as $key => $label)
                                <div class="col-md-3 mb-2">
                                    <label class="small">{{ $label }}</label>
                                    <input type="number" step="0.1" name="{{ $key }}" class="form-control form-control-sm" value="{{ old($key, $logEntry->$key) }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-3">4. Otros y Observaciones</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Landings (Day/Night)</label>
                                <div class="input-group">
                                    <input type="number" name="landings_day" class="form-control" placeholder="Day" value="{{ old('landings_day', $logEntry->landings_day) }}">
                                    <input type="number" name="landings_night" class="form-control" placeholder="Night" value="{{ old('landings_night', $logEntry->landings_night) }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>Observaciones (Remarks)</label>
                                <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $logEntry->remarks) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-3">4. Otros, Observaciones y Adjuntos</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Landings (Day/Night)</label>
                                <div class="input-group">
                                    <input type="number" name="landings_day" class="form-control" placeholder="Day" value="{{ old('landings_day', $logEntry->landings_day) }}">
                                    <input type="number" name="landings_night" class="form-control" placeholder="Night" value="{{ old('landings_night', $logEntry->landings_night) }}">
                                </div>
                            </div>

                            {{-- VISOR DE ARCHIVOS ACTUALES --}}
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold text-primary">Archivos Adjuntos Actuales</label>
                                <ul class="list-group list-group-flush border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                                    @forelse($logEntry->attachments as $file)
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-1">
                                            <small><i class="fa fa-file-pdf-o text-danger"></i> {{ Str::limit($file->name, 25) }}</small>
                                            <a href="{{ asset('storage/'.$file->path) }}" target="_blank" class="btn btn-xs btn-outline-info">Ver</a>
                                        </li>
                                    @empty
                                        <li class="list-group-item text-muted small">No hay archivos previos</li>
                                    @endforelse
                                </ul>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="fw-bold">Subir Nuevos Archivos (PDF, Imágenes)</label>
                                <input type="file" name="files[]" class="form-control" multiple>
                                <small class="text-muted">Si selecciona archivos nuevos, estos se añadirán a los ya existentes.</small>
                            </div>

                            <div class="col-md-12">
                                <label>Observaciones (Remarks)</label>
                                <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $logEntry->remarks) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMNA LATERAL: RESUMEN --}}
            <div class="col-lg-4">
                <div class="card shadow-none border bg-dark text-white sticky-top" style="top: 20px;">
                    <div class="card-body text-center">
                        <h5 class="card-title text-white">Resumen del Vuelo</h5>
                        <hr class="border-light">
                        <h1 class="display-4 fw-bold text-info" id="total_display">{{ number_format($logEntry->total_time, 2) }}</h1>
                        <p class="mb-4">Horas Totales Calculadas</p>
                        
                        <input type="hidden" name="total_time" id="total_time" value="{{ $logEntry->total_time }}">

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold shadow">
                                <i class="fa fa-save"></i> Guardar Cambios
                            </button>
                            <a href="{{ route('log_entries.index') }}" class="btn btn-outline-danger">
                                Cancelar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const hOut = document.getElementById('hobbs_out');
        const hIn = document.getElementById('hobbs_in');
        const totalInp = document.getElementById('total_time');
        const totalDisp = document.getElementById('total_display');

        function calcular() {
            const res = (parseFloat(hIn.value) || 0) - (parseFloat(hOut.value) || 0);
            const final = res > 0 ? res.toFixed(2) : 0.00;
            totalInp.value = final;
            totalDisp.innerText = final;
        }

        hOut.addEventListener('input', calcular);
        hIn.addEventListener('input', calcular);
    });
</script>
@endsection
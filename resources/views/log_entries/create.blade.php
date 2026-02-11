@extends('layouts.admin')

@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<br>
<div class="container-fluid">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Nuevo Registro de Vuelo (Log Entry)</h4>
    </div>

    <form action="{{ route('log_entries.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-4">1. Datos de la Misión</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Fecha</label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Aeronave</label>
                                <select name="aircraft_id" class="form-select" required>
                                    @foreach($aircrafts as $aircraft)
                                        <option value="{{ $aircraft->id }}"> {{ $aircraft->registration }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Origen</label>
                                <select name="origin_id" class="form-select" required>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->icao_code }} - {{ $airport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Destino</label>
                                <select name="destination_id" class="form-select" required>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">{{ $airport->icao_code }} - {{ $airport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Instructor (Opcional)</label>
                                <select name="instructor_id" class="form-control select2-instructor">
                                    <option value="">-- Sin Instructor / Vuelo Solo --</option>
                                    @foreach($instructors as $instructor)
                                        <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-4">2. Distribución de Tiempo (Type of Piloting Time)</h5>
                        <div class="row text-center">
                            @php 
                                $timeFields = ['pic_time' => 'PIC', 'sic_time' => 'SIC', 'solo_time' => 'Solo', 'dual_time' => 'Dual', 'cfi_time' => 'CFI', 'simulator_time' => 'Sim'];
                            @endphp
                            @foreach($timeFields as $field => $label)
                            <div class="col-md-2 mb-3">
                                <label class="small fw-bold">{{ $label }}</label>
                                <input type="number" step="0.1" name="{{ $field }}" class="form-control form-control-sm text-center" value="0.0">
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-4">3. Condiciones e IFR</h5>
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <label class="small fw-bold">Night</label>
                                <input type="number" step="0.1" name="night_time" class="form-control text-center" value="0.0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="small fw-bold">Cross Country</label>
                                <input type="number" step="0.1" name="xc_time" class="form-control text-center" value="0.0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="small fw-bold">Inst. Actual</label>
                                <input type="number" step="0.1" name="instr_actual" class="form-control text-center" value="0.0">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="small fw-bold">Inst. Sim</label>
                                <input type="number" step="0.1" name="instr_sim" class="form-control text-center" value="0.0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold">Approaches (#)</label>
                                <input type="number" name="approaches" class="form-control text-center" value="0">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="small fw-bold">Holds (#)</label>
                                <input type="number" name="holds" class="form-control text-center" value="0">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card bg-dark text-white shadow-none">
                    <div class="card-body">
                        <h5 class="card-title text-white">TIEMPO TOTAL</h5>
                        <hr class="border-light">
                        
                        <input type="hidden" step="0.1" name="hobbs_out" id="hobbs_out" class="form-control border-0" value="0">
                        <input type="hidden" step="0.1" name="hobbs_in" id="hobbs_in" class="form-control border-0"  value="0">
                        
                        <div class="mb-3">
                            <label><strong>Total Time</strong></label>
                            <input type="number" 
                                name="total_time" 
                                id="total_time" 
                                step="0.1" value="0.0" 
                                class="form-control border-0" 
                                style="font-size: 1.2em"
                                />
                        </div>
                        <div style="display: none" class="alert alert-light py-2 text-center text-dark fw-bold mb-0">
                            Total: <span id="total_display">0.0</span> hrs
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Aterrizajes</h5>
                        <div class="row">
                            <div class="col-6">
                                <label class="small">Día</label>
                                <input type="number" name="landings_day" class="form-control text-center" value="1">
                            </div>
                            <div class="col-6">
                                <label class="small">Noche</label>
                                <input type="number" name="landings_night" class="form-control text-center" value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card shadow-none border">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Evidencias & Firma</h5>
                        <textarea name="remarks" class="form-control mb-3" rows="3" placeholder="Observaciones..."></textarea>
                        <input type="file" name="files[]" class="form-control mb-4" multiple>
                        <button type="submit" class="btn btn-success w-100 p-3 fw-bold">GUARDAR REGISTRO</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection



@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Lógica de cálculo Hobbs
        //const hOut = document.getElementById('hobbs_out');
        //const hIn = document.getElementById('hobbs_in');
        const totalInp = document.getElementById('total_time');
        const totalDisp = document.getElementById('total_display');

        function calcular() {
            //const res = (parseFloat(hIn.value) || 0) - (parseFloat(hOut.value) || 0);
            //const final = res > 0 ? res.toFixed(2) : 0.00;
            let final = (parseFloat(totalInp.value);
            totalDisp.innerText = final;
        }

        hOut.addEventListener('input', calcular);
        hIn.addEventListener('input', calcular);
    });
    
    $(document).ready(function() {
        $('.select2-instructor').select2({
            placeholder: "Seleccione un instructor (opcional)",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush

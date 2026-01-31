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
                        <h5 class="card-title text-white">Cómputo Hobbs</h5>
                        <hr class="border-light">
                        <div class="mb-3">
                            <label>Hobbs Out</label>
                            <input type="number" step="0.1" name="hobbs_out" id="hobbs_out" class="form-control border-0">
                        </div>
                        <div class="mb-3">
                            <label>Hobbs In</label>
                            <input type="number" step="0.1" name="hobbs_in" id="hobbs_in" class="form-control border-0">
                        </div>
                        <div class="alert alert-light py-2 text-center text-dark fw-bold mb-0">
                            Total: <span id="total_display">0.0</span> hrs
                            <input type="hidden" name="total_time" id="total_time" value="0.0">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Lógica de búsqueda de piloto
        document.getElementById('pilot_search').addEventListener('input', function(e) {
            const list = document.getElementById('pilot_list');
            const option = Array.from(list.options).find(opt => opt.value === e.target.value);
            document.getElementById('pilot_id').value = option ? option.getAttribute('data-id') : "";
        });

        // Lógica de cálculo Hobbs
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

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
@endsection

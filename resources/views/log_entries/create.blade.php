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
                                <label><strong>Fecha</strong></label>
                                <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Aeronave</strong></label>
                                <select name="aircraft_id" id="aircraft_id" class="form-select select2-aircraft" required>
                                    @foreach($aircrafts as $aircraft)
                                        <option value="">Buscar aeropuerto...</option>
                                        <option value="{{ $aircraft->id }}"> {{ $aircraft->registration }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Origen</strong></label>
                                <select name="origin_id" id="origin_id" class="form-select select2-airport" required>
                                    <option value="">Buscar aeropuerto...</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">[{{ $airport->icao_code }}] {{ $airport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label><strong>Destino</strong></label>
                                <select name="destination_id" id="destination_id" class="form-select select2-airport" required>
                                    <option value="">Buscar aeropuerto...</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}">[{{ $airport->icao_code }}] {{ $airport->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="d-flex align-items-left  mb-1">
                                    <label class="form-label mb-0 alert">¿No ves el aeropuerto que buscas? Puedes registrarlo aquí: &nbsp;</label>
                                    <button type="button" class="btn btn-sm btn-outline-success py-0" data-bs-toggle="modal" data-bs-target="#quickCreateAirportModal">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <p><hr><br></p> 
                            <div class="col-md-6 mb-3">
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

<div class="modal fade" id="quickCreateAirportModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Creación Rápida de Aeropuerto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="quickAirportForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Código ICAO</label>
                        <input type="text" name="icao_code" class="form-control" placeholder="Ej: MGGT" required maxlength="5" style="text-transform:uppercase">
                    </div>
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="name" class="form-control" placeholder="Ej: La Aurora" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar y Seleccionar</button>
                </div>
            </form>
        </div>
    </div>
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
            let final = (parseFloat(totalInp.value));
            totalDisp.innerText = final;
        }

        //hOut.addEventListener('input', calcular);
        //hIn.addEventListener('input', calcular);
    });
    
    $(document).ready(function() {
        $('.select2-instructor').select2({
            placeholder: "Seleccione un instructor (opcional)",
            allowClear: true,
            width: '100%'
        });
    });

    $(document).ready(function() {
        $('.select2-aircraft').select2({
            placeholder: "Seleccione un instructor (opcional)",
            allowClear: true,
            width: '100%'
        });
    });

    $(document).ready(function() {
        // 1. Inicializar Select2 en los aeropuertos
        $('.select2-airport').select2({
            placeholder: "Escriba código ICAO o nombre...",
            allowClear: true,
            width: '100%'
        });

        // 2. Manejar el guardado por AJAX
        $('#quickAirportForm').on('submit', function(e) {
            e.preventDefault();
            
            $.ajax({
                url: "{{ route('airports.store') }}",
                method: "POST",
                data: $(this).serialize(),
                success: function(response) {
                    if(response.success) {
                        
                        // Añadirla y seleccionarla en Origen (o ambos si prefieres)
                        $('#origin_id').append(
                            new Option(response.text, response.id, true, true))
                            .trigger('change');
                        $('#destination_id').append(
                            new Option(response.text, response.id, true, true))
                            .trigger('change');
                        
                        // Limpiar y cerrar modal
                        $('#quickAirportForm')[0].reset();
                        $('#quickCreateAirportModal').modal('hide');
                        
                        alert('Aeropuerto agregado y seleccionado.');
                    }
                },
                error: function(error) {
                    alert('Error al crear el aeropuerto. Verifique si el ICAO ya existe.');
                }
            });
        });
    });
</script>
@endpush

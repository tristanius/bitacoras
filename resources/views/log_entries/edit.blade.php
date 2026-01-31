@extends('layouts.admin')

@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<br>

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h5>Editar Registro de Vuelo #{{ $logEntry->id }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('log_entries.update', $logEntry->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Campos de Vuelo (Iguales al create pero con value) --}}
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Aeronave</label>
                        <select name="aircraft_id" class="form-control" required>
                            @foreach($aircrafts as $aircraft)
                                <option value="{{ $aircraft->id }}" {{ $logEntry->aircraft_id == $aircraft->id ? 'selected' : '' }}>
                                    {{ $aircraft->registration }} ({{ $aircraft->model->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- ... Repetir para Aeropuertos, Tiempos, etc. --}}
                </div>

                {{-- SECCIÓN PARA EL INSTRUCTOR --}}
                @if(auth()->user()->hasRole('instructor') && !$logEntry->validated)
                    <div class="alert alert-info mt-4">
                        <h6>Validación de Instructor</h6>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="approve" id="approve">
                            <label class="form-check-label" for="approve">
                                Dar el "Visto Bueno" (Validar este vuelo)
                            </label>
                        </div>
                    </div>
                @endif

                <div class="text-end mt-4">
                    <a href="{{ route('log_entries.index') }}" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

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
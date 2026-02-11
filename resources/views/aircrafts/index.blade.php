@extends('layouts.admin')
@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6 col-sm-12 ">
                <h3>Gestión de Aeronaves</h3> <br>
            </div>
            <div class="col-6 col-sm-12  text-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createAircraftModal">
                    <i class="fa fa-plus"></i> Nueva Aeronave
                </button>
            </div>
        </div>
    </div>

    <div>
        <div class="alert"> 
            No ves el modelo que buscas? Puedes registrarlo: 
            <a class="btn btn-info btn-sm" href="{{ route('aircraft_models.index') }}" class="alert-link">aquí.</a> 
        </div>
        <hr>
        
        <!--@error('registration')
            <div class="text-danger mt-1" style="color: #ff8300 !important;">
                <strong>La matrícula (registration) "{{ old('registration') }}" ya existe.</strong>
            </div>
        @enderror -->
    </div>    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabla-aircrafts">
                            <thead>
                                <tr>
                                    <th>Matricula</th>
                                    <th>Marca / Modelo</th>
                                    <th>Clase (Categorías)</th>                                    
                                    <th>estado</th>

                                    @if(auth()->user()->hasRole('Admin'))
                                    <th>Cambiar</th>
                                    @endif
                                    <th>Editar</th>

                                    <th>Detach</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aircrafts as $aircraft)
                                <tr>
                                    <td><strong>{{ $aircraft->registration }}</strong></td>
                                    <td>{{ $aircraft->aircraft_model->manufacturer }} / {{ $aircraft->aircraft_model->name }}</td>
                                    <td>
                                        <span class="badge badge-light-primary">
                                            {{ $aircraft->aircraft_model->category->name }}
                                        </span> - {{ $aircraft->aircraft_model->category->description }}
                                    </td>
                                    <td>
                                        <span class="badge {{ $aircraft->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $aircraft->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    @if(auth()->user()->hasRole('Admin'))
                                    <td>
                                        <form action="{{ route('aircraft.toggle', $aircraft) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-light"><i class="fa fa-rotate-right"></i> {{ $aircraft->is_active ? 'Desactivar' : 'Activar' }}</button>
                                        </form>
                                    </td>
                                    @endif
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editAircraft({{ $aircraft->id }}, '{{ $aircraft->registration }}', '{{ $aircraft->aircraft_model->id }}')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                    <td>
                                        @if(auth()->user()->hasRole('Admin'))
                                            <form action="{{ route('aircraft.destroy', $aircraft->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta aeronave permanentemente?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs">Delete</button>
                                            </form>
                                        @else
                                            <form action="{{ route('aircraft.detach', $aircraft->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-xs">Detach</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('aircrafts.update')
@include('aircrafts.create')

@endsection


@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tabla-aircrafts').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
        });
    });

    function editAircraft(id, registration, model_id) {
        // Seteamos la URL del form
        $('#formeditAircraft').attr('action', '/aircraft/' + id);
        
        // Llenamos los campos del modal
        
        $('#edit_registration').val(registration);
        $('#edit_aircraft_model_id').val(model_id); // Esto seleccionará el option correcto
        
        // Mostramos el modal de edición
        var editModal = new bootstrap.Modal(document.getElementById('modaleditAircraft'));
        editModal.show();
    }
</script>
@endpush
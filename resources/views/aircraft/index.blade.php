@extends('layouts.admin')
@section('content')

@include('partials.alerts')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Gestión de Aeronaves</h3>
            </div>
            <div class="col-6 text-end">
                </div>
        </div>
    </div>

    <div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createAircraftModal">
            <i class="fa fa-plus"></i> Nueva Aeronave
        </button>
        <hr>
        
        @error('registration')
            <div class="text-danger mt-1" style="color: #ff8300 !important;">
                <strong>La matrícula (registration) "{{ old('registration') }}" ya existe.</strong>
            </div>
        @enderror
    </div>    
    
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Matricula</th>
                                    <th>Marca / Modelo</th>
                                    <th>Estado</th>
                                    <th>Cambiar estado</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($aircrafts as $aircraft)
                                <tr>
                                    <td><strong>{{ $aircraft->registration }}</strong></td>
                                    <td>{{ $aircraft->brand }} {{ $aircraft->model }}</td>
                                    <td>
                                        <span class="badge {{ $aircraft->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $aircraft->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('aircraft.toggle', $aircraft) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-light">Cambiar Estado</button>
                                        </form>
                                    </td>
                                    <td>
                                        @role('Admin')
                                            <form action="{{ route('aircraft.destroy', $aircraft) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este aeropuerto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fa fa-trash"></i> Eliminar
                                                </button>
                                            </form>
                                        @endrole
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



<div class="modal fade" id="createAircraftModal" tabindex="-1" role="dialog" aria-labelledby="createAircraftModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nueva Aeronave</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('aircraft.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Matrícula (Registration)</label>
                        <input class="form-control @error('registration') is-invalid @enderror" name="registration" type="text" value="{{ old('registration') }}" placeholder="Ej: TG-ABC" required style="text-transform:uppercase">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Marca</label>
                        <input class="form-control" name="brand" type="text" placeholder="Ej: Cessna" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Modelo</label>
                        <input class="form-control" name="model" type="text" placeholder="Ej: 172 Skyhawk" required>
                    </div>
                        <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar Aeronave</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
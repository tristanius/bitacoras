@extends('layouts.admin')
@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Gestión de Aeropuertos</h3>
            </div>
            <div class="col-6 text-end">
                </div>
        </div>
    </div>

    <div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createAirportModal">
            <i class="fa fa-plus"></i> Nuevo Aeropuerto
        </button>
        <hr>
        
        @error('icao_code')
            <div class="text-danger mt-1" style="color: #ff8300 !important;">
                <strong>La Codigo ICAO "{{ old('icao_code') }}" ya existe.</strong>
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
                                    <th>Código ICAO</th>
                                    <th>Nombre del Aeropuerto</th>
                                    <th>Estado</th>
                                    <th>Cambiar estado</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airports as $airport)
                                <tr>
                                    <td><strong>{{ $airport->icao_code }}</strong></td>
                                    <td>{{ $airport->name }}</td>
                                    <td>
                                        <span class="badge {{ $airport->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $airport->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        <form action="{{ route('airports.toggle', $airport) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-light">Cambiar Estado</button>
                                        </form>
                                    </td>
                                    <td>
                                        @role('Admin')
                                            <form action="{{ route('airports.destroy', $airport) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este aeropuerto?');">
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


<div class="modal fade" id="createAirportModal" tabindex="-1" role="dialog" aria-labelledby="createAirportModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nuevo Aeropuerto</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('airports.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Código ICAO (4 letras)</label>
                        <input class="form-control @error('icao_code') is-invalid @enderror" name="icao_code" type="text" value="{{ old('icao_code') }}" placeholder="Ej: MGGT" maxlength="4" required style="text-transform:uppercase">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre del Aeropuerto</label>
                        <input class="form-control" name="name" type="text" placeholder="Ej: Puerto Barrios" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar Aeropuerto</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
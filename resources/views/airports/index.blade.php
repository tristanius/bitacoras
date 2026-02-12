@extends('layouts.admin')
@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h3>Gestión de Aeropuertos</h3> <br>
            </div>
            <div class="col-md-6 col-sm-12 text-end">
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#createAirportModal">
                    <i class="fa fa-plus"></i> Nuevo Aeropuerto
                </button>
            </div>
        </div>
    </div>

    <div>
        
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
                                    <th>Código ICAO/IATA</th>
                                    <th>Nombre del Aeropuerto</th>
                                    <th>Estado</th>
                                    <th>Privacidad</th>
                                    @if(auth()->user()->hasRole('Admin'))
                                    <th>Cambiar estado</th>
                                    @endif
                                    <th>
                                        @if(auth()->user()->hasRole('Admin'))
                                        Eliminar
                                        @else
                                        Quitar
                                        @endif
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airports as $airport)
                               <tr>
                                    <td>{{ $airport->icao_code }}</td>
                                    <td>{{ $airport->name }}</td>
                                    <td>
                                        <span class="badge {{ $airport->is_active ? 'bg-success' : 'bg-danger' }}">
                                            {{ $airport->is_active ? 'Activo' : 'Inactivo' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($airport->is_public)
                                            <span class="badge badge-info">Público</span>
                                        @else
                                            <span class="badge badge-warning">Privado</span>
                                        @endif
                                    </td>
                                    @if(auth()->user()->hasRole('Admin'))
                                    <td>
                                        <form action="{{ route('airports.toggle', $airport) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-light">Cambiar Estado</button>
                                        </form>
                                    </td>
                                    @endif
                                    <td>
                                        @if(auth()->user()->hasRole('Admin'))
                                            <form action="{{ route('airports.destroy', $airport->id) }}" method="POST" style="display:inline;">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-danger btn-xs" type="submit">Eliminar</button>
                                            </form>
                                        @elseif(!$airport->is_public)
                                            <form action="{{ route('airports.detach', $airport->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button class="btn btn-warning btn-xs" type="submit">quitar</button>
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
                        <label class="form-label">Código ICAO/IATA</label>
                        <input class="form-control @error('icao_code') is-invalid @enderror" name="icao_code" 
                            type="text" value="{{ old('icao_code') }}" placeholder="Ej: MGGT" maxlength="25" 
                            required 
                            style="text-transform:uppercase">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre del Aeropuerto</label>
                        <input class="form-control" name="name" type="text" placeholder="Ej: Puerto Barrios" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Es publico?</label>
                        <input class="form-control form-check-input" name="is_public" type="checkbox" value="0">
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
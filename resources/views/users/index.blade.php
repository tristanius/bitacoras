@extends('layouts.admin')
@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <h3 class="fw-bold" style="font-family: 'Montserrat', sans-serif;">Gestión de Personal Aeronáutico</h3>
    
        <div class="col-12 text-end">
            <a href="{{ route('users.create') }}" class="btn btn-primary fw-bold">
                <i class="fa fa-plus"></i> NUEVO USUARIO
            </a>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive" >
                <table class="table table-hover" id="tabla-usuarios">
                    <thead>
                        <tr>
                            <th class="fw-bold">Nombre</th>
                            <th class="fw-bold">Correo</th>
                            <th class="fw-bold">Rol</th>
                            <th class="fw-bold">Estado</th>
                            <th>Cambiar</th>
                            <th class="fw-bold">Acciones</th>
                            <th>Reset Passwd.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="fw-bold">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->getRoleNames() as $role)
                                    <span class="badge bg-info text-dark">{{ strtoupper($role) }}</span>
                                @endforeach
                            </td>
                            <td>
                                @if($user->is_active)
                                    <span class="badge bg-success">ACTIVO</span>
                                @else
                                    <span class="badge bg-danger">INACTIVO</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('users.toggle', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->is_active ? 'btn-danger' : 'btn-success' }}">
                                        {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-info">Editar</a>                                
                            </td>
                            <td>
                                <form action="{{ route('users.reset', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-sm btn-warning fw-bold" 
                                            onclick="return confirm('¿Seguro que desea restablecer la clave de este usuario a password123?')">
                                        <i class="fa fa-key"></i> 
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
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
        $('#tabla-usuarios').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
        });
    });
</script>
@endpush
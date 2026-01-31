@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0">EDITAR USUARIO: {{ strtoupper($user->name) }}</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT') {{-- ¡Vital para que Laravel sepa que es actualización! --}}

                <div class="mb-3">
                    <label class="form-label">Nombre Completo</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol Asignado</label>
                    <select name="role" class="form-control" required>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" 
                                {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                {{ strtoupper($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="alert alert-warning small">
                    <i class="fa fa-info-circle"></i> La contraseña no se edita aquí por seguridad. Use el botón "Reset Pass" en la lista principal si es necesario.
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light">Cancelar</a>
                    <button type="submit" class="btn btn-info px-4">GUARDAR CAMBIOS</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.admin')
@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('content')
<div class="container-fluid">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Perfil del Usuario</h4>
    </div>

    <div class="row">
        <div class="col-xl-4">
            <div class="card shadow-none border">
                <div class="card-body text-center">
                    <div class="profile-user-img mb-3">
                        @if($user->photo)
                            <img src="{{ asset('storage/'.$user->photo) }}" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                                <h1 class="mb-0">{{ substr($user->name, 0, 1) }}</h1>
                            </div>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-muted text-uppercase small fw-bold">{{ $user->getRoleNames()->first() }}</p>
                    
                    <div class="mt-4 pt-2 border-top">
                        <div class="row">
                            <div class="col-6 border-end">
                                <h5 class="text-primary mb-1">{{ $totalHours }}</h5>
                                <p class="text-muted mb-0 small">Horas Totales</p>
                            </div>
                            <div class="col-6">
                                <h5 class="text-success mb-1">{{ $user->is_active ? 'Activo' : 'Inactivo' }}</h5>
                                <p class="text-muted mb-0 small">Estado Cuenta</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8">
            <div class="card shadow-none border">
                <div class="card-header">
                    <h5 class="card-title mb-0">Información Personal</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Cambiar Foto de Perfil</label>
                                <input type="file" name="photo" class="form-control">
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary px-4">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow-none border mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0 text-danger">Seguridad de la Cuenta</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.password.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nueva Contraseña</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Confirmar Contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control">
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-outline-danger">Actualizar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
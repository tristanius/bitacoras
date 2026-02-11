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
                        @if($user->profile_photo)
                        <div class="bg-primary text-white d-flex align-items-center justify-content-center mx-auto">
                           <img src="{{ asset('storage/'.$user->profile_photo) }}" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;"> 
                        </div>                            
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
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Correo Electrónico</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" readonly >
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Documento</label>
                                <select class="form-select" name="doc_type" required>
                                    <option value="DUI" {{ (old('doc_type') ?? $user->doc_type ?? '') == 'DUI' ? 'selected' : '' }}>DUI</option>
                                    <option value="Extrajero" {{ (old('doc_type') ?? $user->doc_type ?? '') == 'Extrajero' ? 'selected' : '' }}>Documento de extranjería</option>
                                    <option value="Pasaporte" {{ (old('doc_type') ?? $user->doc_type ?? '') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                    <option value="NIT" {{ (old('doc_type') ?? $user->doc_type ?? '') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Número de Identificación (NUIP/DUI)</label>
                                <input class="form-control @error('doc_number') is-invalid @enderror" 
                                    name="doc_number" 
                                    type="text" 
                                    value="{{ old('doc_number') ?? $user->doc_number ?? '' }}" 
                                    placeholder="Ej: 00000000-0" 
                                    required>
                                @error('doc_number')
                                    <div class="invalid-feedback">Este número de identificación ya existe.</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Licencia</label>
                                <input class="form-control" name="license_number" type="text" value="{{ $user->license_number }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Vencimiento Médica</label>
                                <input class="form-control" name="medical_certificate_expiry" type="date" value="{{ $user->medical_certificate_expiry }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono</label>
                                <input class="form-control" name="phone" type="text" value="{{ $user->phone }}">
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
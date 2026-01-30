@extends('others.layout_others.master')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('others-content')
<x-guest-layout>
    <div class="login-card">
        <div class="login-main">
            <form class="theme-form" method="POST" action="{{ route('password.email') }}">
                @csrf
                <h2 class="text-center">Recuperar Contraseña</h2>
                <p class="text-center text-muted">Le enviaremos un link a su correo para restablecer su acceso.</p>

                <x-auth-session-status class="mb-4 alert alert-success" :status="session('status')" />

                <div class="form-group">
                    <label class="col-form-label">Correo Electrónico</label>
                    <input class="form-control" type="email" name="email" :value="old('email')" required autofocus placeholder="piloto@ejemplo.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
                </div>

                <div class="form-group mb-0">
                    <button class="btn btn-primary btn-block w-100 mt-3" type="submit">
                        ENVIAR LINK DE RECUPERACIÓN
                    </button>
                </div>

                <p class="mt-4 mb-0 text-center">
                    <a class="ms-2" href="{{ route('login') }}">Volver al Inicio de Sesión</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
@endsection
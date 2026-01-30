@extends('others.layout_others.master')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('others-content')
    <div class="login-card"> {{-- Clase típica de la plantilla Koho --}}
        <div>
            <div class="login-main"> 
                <form class="theme-form" method="POST" action="{{ route('register') }}">
                    @csrf
                    <h2 class="text-center">Crear Cuenta</h2>
                    <p class="text-center">Ingrese sus datos personales para registrarse</p>
                    
                    <div class="form-group">
                        <label class="col-form-label">Nombre Completo</label>
                        <input class="form-control" type="text" name="name" required placeholder="Juan Pérez">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Correo Electrónico</label>
                        <input class="form-control" type="email" name="email" required placeholder="piloto@ejemplo.com">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Contraseña</label>
                        <input class="form-control" type="password" name="password" required placeholder="*********">
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Confirmar Contraseña</label>
                        <input class="form-control" type="password" name="password_confirmation" required placeholder="*********">
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-primary btn-block w-100 mt-3" type="submit">CREAR CUENTA</button>
                    </div>

                    <p class="mt-4 mb-0 text-center">¿Ya tienes cuenta?<a class="ms-2" href="{{ route('login') }}">Inicia sesión</a></p>
                </form>
            </div>
        </div>
    </div>

@endsection
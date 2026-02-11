@extends('others.layout_others.master')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('others-content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7">
                <img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/banner.jpeg') }}" alt="bg2">
            </div>
            <div class="col-xl-5 p-0">
                <div class="login-card"> {{-- Clase típica de la plantilla Koho --}}
                    <div>
                        <div class="login-main"> 
                            <form class="theme-form" method="POST" action="{{ route('register') }}">
                                @csrf
                                <h2 class="text-center">Crear Cuenta </h2>
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
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" id="password" required placeholder="*********">
                                        <div class="show-hide"><span id="togglePassword" class="show"> </span></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-form-label">Confirmar Contraseña</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required placeholder="*********">
                                        <div class="show-hide"><span id="togglePassword1" class="show"> </span></div>
                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <button class="btn btn-primary btn-block w-100 mt-3" type="submit">CREAR CUENTA</button>
                                </div>

                                <p class="mt-4 mb-0 text-center">¿Ya tienes cuenta?<a class="ms-2" href="{{ route('login') }}">Inicia sesión</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>

<script>
    document.getElementById('togglePassword').addEventListener('click', function (e) {
        // Seleccionamos el input
        const passwordInput = document.getElementById('password');
        
        // Alternamos el tipo de input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });

    document.getElementById('togglePassword1').addEventListener('click', function (e) {
        // Seleccionamos el input
        const passwordInput = document.getElementById('password_confirmation');
        
        // Alternamos el tipo de input
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
    });
    
</script>   

@endsection
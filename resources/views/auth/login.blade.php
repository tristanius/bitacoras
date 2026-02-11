@extends('others.layout_others.master')

    <style>
         /* Aplicación global */.
        body {
            font-family: 'Montserrat', sans-serif !important;
            font-size: 1em;
        }
        body, h1, h2, h3, h4, h5, h6, .btn, .form-control, .sidebar-link, .page-title {
            font-family: 'Montserrat', sans-serif !important;
            letter-spacing: 0.1px;
        }
    
        /* Opcional: Para que los textos de los inputs no se vean tan pesados, 
        podemos dejar el peso normal pero la misma fuente */
        input::placeholder, .text-muted, span, p, a, small {
            font-weight: 400 !important;.
            letter-spacing: 0.1px;
            font-size: 1em;
        }
    </style>
@include('partials.alerts')
@section('others-content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7"><img class="bg-img-cover bg-center" src="{{ asset('assets/images/login/banner.jpeg') }}" alt="bg2"></div>
            <div class="col-xl-5 p-0">
                <div class="login-card">
                    <div>
                        <div>
                            <a class="logo" href="{{ route('dashboard') }}">
                                <img class="img-fluid for-light"
                                    src="{{ asset('assets/images/logo/logo.png') }}" style="width: 70%" alt="logo Image">
                            </a>
                        </div>
                        <div class="login-main">
                            <form class="theme-form" method="POST" action="{{ route('login') }}">
                                @csrf
                                <h2 class="text-center">Ingresa a tu cuenta</h2>
                                <p class="text-center">Ingrese su correo y su contraseña para iniciar</p>
                                <div class="form-group">
                                    <label class="col-form-label">Correo Electrónico</label>
                                    <input class="form-control" type="email" name="email" id="email" required="" placeholder="Test@gmail.com">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Contraseña</label>
                                    <div class="form-input position-relative">
                                        <input class="form-control" type="password" name="password" id="password" required=""
                                            placeholder="*********">
                                        <div class="show-hide"><span class="show"> </span></div>
                                    </div>
                                </div>
                                <div class="form-group mb-0">
                                    <div class="checkbox p-0">
                                        <input id="checkbox1" type="checkbox">
                                        <label class="text-muted" for="checkbox1">Recordar contraseña</label>
                                    </div><a class="link" href="{{ route('password.request') }}">olvidó su contraseña?</a>
                                    <div class="text-end mt-3">
                                        <button class="btn btn-primary btn-block w-100" type="submit">Ingresar</button>
                                    </div>
                                </div>
                                <div class="login-social-title">
                                    <h3>Registro</h3>
                                </div>
                                <div class="form-group">
                                    
                                </div>
                                <p class="mt-4 mb-0 text-center">¿No tienes una cuenta?<a class="ms-2"
                                        href="{{ route('register')}}">Crear cuenta</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

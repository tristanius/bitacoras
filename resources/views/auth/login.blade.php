@extends('others.layout_others.master')

@include('partials.alerts')

@section('others-content')
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
                                    </div><a class="link" href="{{ route('forget-password')}}">olvidó su contraseña?</a>
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
                                        href="{{ route('sign-up')}}">Crear cuenta</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection

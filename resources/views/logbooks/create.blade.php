@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card shadow-none border">
                <div class="card-header bg-primary text-white">
                    <h5 class="card-title mb-0 text-white">Nueva Bitácora (Logbook)</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('logbooks.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre de la Bitácora</label>
                            <input type="text" name="name" class="form-control" placeholder="Ej: Vuelos Piper PA-28 2026" required>
                            <small class="text-muted">Use un nombre que le ayude a identificar el bloque de vuelos.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Fecha de Apertura</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="is_active" value="1">

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('logbooks.index') }}" class="btn btn-light">Cancelar</a>
                            <button type="submit" class="btn btn-success px-4">Crear Carpeta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
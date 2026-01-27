{{-- Mensajes de Éxito --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

{{-- Mensajes de Error de Validación (Como la matrícula repetida) --}}
@if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; border-left: 5px solid #ff8300;">
        <i class="fa fa-exclamation-triangle"></i> <strong>¡Atención!</strong>
        <ul class="mb-0 mt-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
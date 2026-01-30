@extends('layouts.admin')

@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

 <br>
<div class="container-fluid card">
    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Bitácoras (Logbooks)</h4>
        <a href="{{ route('logbooks.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Nueva Bitácora
        </a>
    </div>

    <div class="row">
        @foreach($logbooks as $logbook)
        <div class="col-xl-4 col-sm-6">
            <div class="card shadow-none border">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="avatar-sm">
                                <span class="avatar-title bg-soft-primary text-primary rounded-circle fs-2">
                                    <i class="fa fa-folder"></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15 mb-1 text-truncate">
                                <a href="{{ route('logbooks.show', $logbook->id) }}" class="text-dark">{{ $logbook->name }}</a>
                            </h5>
                            <p class="text-muted mb-0">{{ $logbook->log_entries_count }} Registros de vuelo</p>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-transparent border-top text-center">
                    <a href="{{ route('logbooks.show', $logbook->id) }}" class="btn btn-light btn-sm w-100">
                        Abrir Carpeta <i class="fa fa-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
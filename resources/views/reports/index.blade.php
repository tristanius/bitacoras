@extends('layouts.admin')
@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
        <div class="col-md-6 col-sm-12">
            <h3>Centro de Descargas - Logbooks Oficiales</h3>
        </div>
        <br>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-none border">
                <div class="card-header bg-primary py-3">
                    <h5 class="card-title mb-0 text-white"><i class="fa fa-user"></i> Reporte por Piloto</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.pilot_pdf') }}" method="GET" target="_blank">
                        @if(auth()->user()->hasAnyRole(['Admin', 'Oficial de Operaciones']))
                        <div class="mb-3">
                            <label class="form-label fw-bold">Seleccionar Piloto</label>
                            <select name="pilot_id" class="form-select" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($pilots as $pilot)
                                    <option value="{{ $pilot->id }}">{{ $pilot->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                           <div class="mb-3">
                            <label class="form-label fw-bold">Piloto</label>
                            <select name="pilot_id" class="form-select" required>
                                <option value="{{ auth()->user()->id }}">{{ auth()->user()->name }}</option>                                
                            </select>
                        </div> 
                        @endif
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small">Desde</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small">Hasta</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fa fa-file-pdf-o"></i> Descargar PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @role('Admin')
        <div class="col-md-6">
            <div class="card shadow-none border">
                <div class="card-header bg-dark py-3">
                    <h5 class="card-title mb-0 text-white"><i class="fa fa-plane"></i> Reporte por Aeronave</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reports.aircraft_pdf') }}" method="GET" target="_blank">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Seleccionar Aeronave</label>
                            <select name="aircraft_id" class="form-select" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($aircrafts as $aircraft)
                                    <option value="{{ $aircraft->id }}">{{ $aircraft->registration }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="form-label small">Desde</label>
                                <input type="date" name="start_date" class="form-control" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="form-label small">Hasta</label>
                                <input type="date" name="end_date" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fa fa-file-pdf-o"></i> Descargar PDF
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endrole
    </div>
</div>
@endsection
@extends('layouts.admin')


@include('partials.alerts')
@include('partials.monserrat_font')

@section('content')
<div class="container-fluid">
    <div class="card shadow-none border">
        <div class="card-header bg-primary text-white" style="background-color: #183053 ">
            <h5 class="mb-0 text-white">Centro de Reportes y Consultas</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('log_entries.reports') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Piloto</label>
                    <select name="pilot_id" class="form-select form-select-sm">
                        @if(auth()->user()->hasAnyRole(['Admin', 'Oficial de Operaciones']))
                            <option value="">-- Todos los Pilotos --</option>
                        @endif
                        @foreach($pilots as $p)
                            <option value="{{ $p->id }}" {{ request('pilot_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Aeronave</label>
                    <select name="aircraft_id" class="form-select form-select-sm">
                        <option value="">-- Todas --</option>
                        @foreach($aircrafts as $a)
                            <option value="{{ $a->id }}" {{ request('aircraft_id') == $a->id ? 'selected' : '' }}>{{ $a->registration }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Desde</label>
                    <input type="date" name="date_from" class="form-control form-control-sm" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">Hasta</label>
                    <input type="date" name="date_to" class="form-control form-control-sm" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">Consultar</button>
                    <a href="{{ route('log_entries.export', request()->all()) }}" class="btn btn-success btn-sm w-100">
                        <i class="fa fa-file-excel-o"></i> CSV
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLA DE RESULTADOS (Similar al index) --}}
    <div class="card shadow-none border mt-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Piloto</th>
                            <th>Aeronave</th>
                            <th>Ruta</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($entries as $entry)
                            <tr  @if(!$entry->is_active) style="background-color: #f8d7da; opacity: 0.7;" @endif>
                                <td>{{ $entry->date }}</td>
                                <td>{{ $entry->pilot->name }}</td>
                                <td>{{ $entry->aircraft->registration }}</td>
                                <td>{{ $entry->origin->icao_code }} ➔ {{ $entry->destination->icao_code }}</td>
                                <td>{{ $entry->total_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $entries->appends(request()->input())->links() }}
        </div>
    </div>
</div>
@endsection
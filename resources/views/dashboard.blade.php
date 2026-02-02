@extends('layouts.admin')

@include('partials.monserrat_font')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/prism.css') }}">
@endsection

@section('content')
<div class="container-fluid">
    

    <div class="row">
        <div class="col-xl-7 col-lg-10">
            <div class="card profile-greeting">
                <div class="card-body">
                    <div>
                        <h1>Welcome,  {{ auth()->user()->name }} </h1>
                        <p>  {{ Auth::user()->getRoleNames()->first() }} </p>
                        <a class="btn" href="{{ route('profile.show') }}">Mi cuenta<i data-feather="arrow-right"></i></a>
                    </div>
                    <div class="greeting-img">
                        <img class="img-fluid" src="{{ asset('assets/images/login/banner.jpeg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white shadow-sm border-0">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            @if(auth()->user()->profile_photo)
                                <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" class="rounded-circle img-thumbnail" style="width: 80px; height: 80px;">
                            @else
                                <div class="rounded-circle bg-white text-primary d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <h2 class="mb-0">{{ substr($user->name, 0, 1) }}</h2>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1 ms-4">
                            <h3 class="mb-1">¡Bienvenido de nuevo, {{ auth()->user()->name }}!</h3>
                            <p class="mb-0 opacity-75">Tienes <strong>{{ $userStats['my_total_hours'] }}</strong> horas acumuladas. Tu último vuelo fue el {{ optional($userStats['my_last_flight'])->date ?? 'N/A' }}.</p>
                        </div>
                        <div class="text-end d-none d-md-block">
                            <span class="badge bg-light text-primary p-2 px-3 text-uppercase">{{ $userStats['role'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
        <h4 class="mb-sm-0">Dashboard Operativo</h4>
    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow-none border border-primary text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Horas Histórico</h6>
                    <h3 class="text-primary">{{ number_format($stats['total_hours'], 1) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-none border border-success text-center">
                <div class="card-body">
                    <h6 class="text-muted">Vuelos este Mes</h6>
                    <h3 class="text-success">{{ $stats['flights_month'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-none border border-info text-center">
                <div class="card-body">
                    <h6 class="text-muted">Aeronaves Activas</h6>
                    <h3 class="text-info">{{ $stats['active_aircraft'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-none border border-warning text-center">
                <div class="card-body">
                    <h6 class="text-muted">Pendientes Validar</h6>
                    <h3 class="text-warning">{{ $stats['pending_validations'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-none border">
                <div class="card-header"><h6>Tendencia de Vuelo (Horas Mensuales)</h6></div>
                <div class="card-body">
                    <canvas id="monthlyChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-none border">
                <div class="card-header"><h6>Distribución por Aeronave</h6></div>
                <div class="card-body">
                    <canvas id="aircraftChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-none border">
                <div class="card-header"><h6>Tendencia Mensual (Horas)</h6></div>
                <div class="card-body"><canvas id="monthlyChart"></canvas></div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-none border">
                <div class="card-header"><h6>Destinos más Visitados</h6></div>
                <div class="card-body">
                    <canvas id="destinationsChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-none border">
                <div class="card-header"><h6>Actividad Reciente en Bitácoras</h6></div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Piloto</th>
                                    <th>Avión</th>
                                    <th>Destino</th>
                                    <th>Fecha</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentActivity as $activity)
                                <tr>
                                    <td>{{ $activity->pilot->name }}</td>
                                    <td><span class="badge bg-soft-info text-info">{{ $activity->aircraft->registration }}</span></td>
                                    <td>{{ $activity->destination->icao_code }}</td>
                                    <td>{{ \Carbon\Carbon::parse($activity->date)->format('d/m') }}</td>
                                    <td>
                                        @if($activity->validated)
                                            <i class="fa fa-check-circle text-success"></i>
                                        @else
                                            <i class="fa fa-clock-o text-warning"></i>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-none border">
                <div class="card-header"><h6>Flota por Horas</h6></div>
                <div class="card-body"><canvas id="aircraftChart"></canvas></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gráfico de Líneas - Horas Mensuales
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels) !!},
            datasets: [{
                label: 'Horas Voladas',
                data: {!! json_encode($monthlyData) !!},
                borderColor: '#0b5394',
                backgroundColor: 'rgba(11, 83, 148, 0.1)',
                fill: true,
                tension: 0.4
            }]
        }
    });

    // Gráfico de Dona - Uso por Aeronave
    new Chart(document.getElementById('aircraftChart'), {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($aircraftLabels) !!},
            datasets: [{
                data: {!! json_encode($aircraftData) !!},
                backgroundColor: ['#0b5394', '#2980b9', '#3498db', '#5dade2', '#aed6f1']
            }]
        }
    });

    new Chart(document.getElementById('destinationsChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($destLabels) !!},
            datasets: [{
                label: 'Visitas',
                data: {!! json_encode($destData) !!},
                backgroundColor: '#3d85c6',
                borderRadius: 5
            }]
        },
        options: {
            indexAxis: 'y', // Hace que la barra sea horizontal
            plugins: { legend: { display: false } }
        }
    });
</script>
@endpush


@section('scripts')
<script src="{{ asset('assets/js/chart/knob/knob.min.js') }}"></script>
<script src="{{ asset('assets/js/chart/knob/knob-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/apex-chart.js') }}"></script>
<script src="{{ asset('assets/js/chart/apex-chart/stock-prices.js') }}"> </script>
<script src="{{ asset('assets/js/prism/prism.min.js') }}"></script>
<script src="{{ asset('assets/js/clipboard/clipboard.min.js') }}"></script>
<script src="{{ asset('assets/js/custom-card/custom-card.js') }}"></script>
<script src="{{ asset('assets/js/notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard/default.js') }}"></script>
<script src="{{ asset('assets/js/notify/index.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.bundle.js') }}"></script>
<script src="{{ asset('assets/js/typeahead/typeahead.custom.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/handlebars.js') }}"></script>
<script src="{{ asset('assets/js/typeahead-search/typeahead-custom.js') }}"></script>
@endsection

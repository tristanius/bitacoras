@extends('layouts.admin')

@section('content')

@include('partials.alerts')
@include('partials.monserrat_font')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <h3>Gestión de Pilotos</h3>
            </div>
            <div class="col-md-6 col-sm-12 text-end">
                <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#createPilotModal">
                    <i class="fa fa-plus"></i> Nuevo Piloto
                </button>
            </div>
        </div>
    </div>
    @error('registration')
        <div class="text-danger mt-1" style="color: #ff8300 !important;">
            <strong>La matrícula (registration) "{{ old('registration') }}" ya existe.</strong>
        </div>
    @enderror
</div>

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
@endsection

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover display" id="basic-1">
                    <thead>
                        <tr>
                            <th>No. de identificación</th>
                            <th>Tipo de documento</th>
                            <th>Nombre</th>
                            <th>Licencia</th>
                            <th>Certi. Médico exp.</th>
                            <th>Teléfono</th>
                            <th>Estado</th>
                            <th>Cambiar estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pilots as $pilot)
                        <tr>
                            <td>{{ $pilot->doc_number }}</td>
                            <td>{{ $pilot->doc_type }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-circle symbol-40px me-3">
                                        @if($pilot->profile_photo)
                                            <img src="{{ asset('storage/' . $pilot->profile_photo) }}" alt="Avatar" style="object-fit: cover;" width="50">
                                        @else
                                            <div class="symbol-label fs-4 fw-bold bg-soft-primary text-primary">
                                                {{ substr($pilot->name, 0, 1) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="d-flex flex-column">
                                        <a href="#" class="text-dark fw-bolder text-hover-primary fs-6">{{ $pilot->name }}</a>
                                        <span class="text-muted fw-bold" style="font-size: 0.8rem;">{{ $pilot->email }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $pilot->license_number }}</td>
                            <td class="{{ \Carbon\Carbon::parse($pilot->medical_certificate_expiry)->isPast() ? 'text-danger fw-bold' : '' }}">
                                {{ $pilot->medical_certificate_expiry }}
                            </td>
                            <td>{{ $pilot->phone }}</td>
                            <td>
                                <span class="badge {{ $pilot->is_active ? 'bg-success' : 'bg-danger' }}">
                                    {{ $pilot->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('pilot.toggle', $pilot) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-sm btn-{{ $pilot->is_active ? 'warning' : 'success' }}"> <i class="{{ $pilot->is_active ? 'fa fa-pause-circle-o':'fa fa-check' }}"></i></button>
                                </form>
                            </td>
                            <td>
                                <button class="btn btn-light btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $pilot->id }}" style="color:navy">
                                    <i class="fa fa-edit"></i>
                                </button>     
                                
                                <form action="{{ route('pilots.destroy', $pilot->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este piloto? Esta acción no se puede deshacer.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                        @include('pilots.partials.update_modal')

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('pilots.partials.create_modal')

@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Esto activará el buscador, paginación y ordenamiento automáticamente si Koho tiene DataTables
        $('.table').DataTable({
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            }
        });
    });
</script>
@endpush
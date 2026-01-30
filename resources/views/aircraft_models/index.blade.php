@extends('layouts.admin')

@include('partials.alerts')
@include('partials.monserrat_font')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
@endsection

@section('content')

<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6"><h3>Modelos de Aeronaves</h3></div>
            <div class="col-6">
                <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#modalCreateModel">
                    <i class="fa fa-plus"></i> Nuevo Modelo
                </button>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tabla-modelos">
                    <thead>
                        <tr>
                            <th>Modelo</th>
                            <th>Fabricante</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($models as $model)
                        <tr>
                            <td>{{ $model->name }}</td>
                            <td>{{ $model->manufacturer }}</td>
                            <td>
                                @if($model->category->name == 'ACEL')
                                    <span class="badge badge-light-success">ACEL</span>
                                @elseif($model->category->name == 'AMEL')
                                    <span class="badge badge-light-warning">AMEL</span>
                                @else
                                    <span class="badge badge-light-info">{{ $model->category->name }}</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="editModel({{ $model->id }}, '{{ $model->name }}', '{{ $model->manufacturer }}', '{{ $model->category->id }}' )">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <form action="{{ route('aircraft_models.destroy', $model->category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('aircraft_models.update_modal')
@include('aircraft_models.create_modal')
@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        $('#tabla-modelos').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
        });
    });

    function editModel(id, name, manufacturer, category_id) {
        // Seteamos la URL del form
        $('#formEditModel').attr('action', '/aircraft_models/' + id);
        
        // Llenamos los campos del modal
        $('#edit_name').val(name);
        $('#edit_manufacturer').val(manufacturer);
        $('#edit_aircraft_category_id').val(category_id).trigger('change'); // Esto seleccionará el option correcto
        // Mostramos el modal de edición
        var editModal = new bootstrap.Modal(document.getElementById('modalEditModel'));
        editModal.show();
    }
</script>
@endpush
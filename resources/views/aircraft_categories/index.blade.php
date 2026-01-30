@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/datatable-extension.css') }}">
@endsection

@include('partials.alerts')

@section('content')
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-6">
                <h3>Categorías de Aeronaves</h3>
            </div>
            <div class="col-6">
                <button class="btn btn-primary float-end" type="button" data-bs-toggle="modal" data-bs-target="#modalCreateCategory">
                    <i class="fa fa-plus"></i> Nueva Categoría
                </button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="tabla-categorias">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td><strong>{{ $category->name }}</strong></td>
                                    <td>{{ $category->description ?? 'Sin descripción' }}</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm" onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <form action="{{ route('aircraft_categories.destroy', $category->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Eliminar esta categoría?')">
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
    </div>
</div>

{{-- Incluimos el Modal de Creación --}}
@include('aircraft_categories.create_modal')
@include('aircraft_categories.update_modal')

@endsection

@section('scripts')
<script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
@endsection


@push('scripts')
<script>
    $(document).ready(function() {
        $('#tabla-categorias').DataTable({
            language: { url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json' }
        });
    });

    function editCategory(id, name, description) {
        // Seteamos la URL del form dinámicamente
        $('#formEditCategory').attr('action', '/aircraft_categories/' + id);
        
        // Llenamos los campos
        $('#edit_name').val(name);
        $('#edit_description').val(description);
        
        // Mostramos el modal
        var myModal = new bootstrap.Modal(document.getElementById('modalEditCategory'));
        myModal.show();
    }
</script>
@endpush
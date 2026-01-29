<div class="modal fade" id="modalEditModel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditModel" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Categoría</label>
                        <input class="form-control" name="name" id="edit_name" type="text" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="manufacturer" id="edit_manufacturer" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría Técnica </label>
                        <select class="form-select" name="edit_aircraft_category_id" required id="edit_aircraft_category_id">
                            <option value="">Seleccione una categoría...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
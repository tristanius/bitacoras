<div class="modal fade" id="modalEditCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Editar Categoría</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditCategory" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Categoría</label>
                        <input class="form-control" name="name" id="edit_name" type="text" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea class="form-control" name="description" id="edit_description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
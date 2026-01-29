<div class="modal fade" id="modalCreateCategory" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Categoría Técnica</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('aircraft_categories.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Categoría</label>
                        <input class="form-control" name="name" type="text" placeholder="Ej: Monomotor, Bimotor, Helicóptero" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descripción (Opcional)</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar Categoría</button>
                </div>
            </form>
        </div>
    </div>
</div>
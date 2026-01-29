<div class="modal fade" id="modalCreateModel" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Modelo</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('aircraft_models.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nombre del Modelo</label>
                        <input class="form-control" name="name" type="text" placeholder="Ej: Cessna 172" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fabricante</label>
                        <input class="form-control" name="manufacturer" type="text" placeholder="Ej: Cessna" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Categoría Técnica</label>
                        <select class="form-select" name="aircraft_category_id" required>
                            <option value="">Seleccione una categoría...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Guardar Modelo</button>
                </div>
            </form>
        </div>
    </div>
</div>
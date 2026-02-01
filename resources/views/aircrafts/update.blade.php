
<div class="modal fade" id="modaleditAircraft" tabindex="-1" role="dialog" aria-labelledby="formeditAircraft" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Agregar Nueva Aeronave</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formeditAircraft" action="{{ route('aircraft.store') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Matrícula (Registration)</label>
                        <input class="form-control @error('registration') is-invalid @enderror" name="registration" id="edit_registration" type="text" value="{{ old('registration') }}" placeholder="Ej: TG-ABC" required style="text-transform:uppercase">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Seleccionar Marca/Modelo</label>
                        <select class="form-select" name="aircraft_model_id" id="edit_aircraft_model_id" required>
                            <option value="">Seleccione el modelo...</option>
                            @foreach($models as $model)
                                <option value="{{ $model->id }}">
                                    {{ $model->manufacturer }} {{ $model->name }} ({{ $model->category->name }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary" type="submit">Guardar Aeronave</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
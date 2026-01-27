<div class="modal fade" id="editModal{{ $pilot->id }}" tabindex="-1" role="dialog">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Editar Piloto: {{ $pilot->name }}</h5>
                                        <button class="btn-close" type="button" data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('pilots.update', $pilot->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body">
                                            <div class="col-md-5 mb-3">
                                                <label class="form-label">Tipo de Documento</label>
                                                <select class="form-select" name="doc_type" required>
                                                    <option value="DUI" {{ (old('doc_type') ?? $pilot->doc_type ?? '') == 'DUI' ? 'selected' : '' }}>DUI</option>
                                                    <option value="Extrajero" {{ (old('doc_type') ?? $pilot->doc_type ?? '') == 'Extrajero' ? 'selected' : '' }}>Documento de extranjería</option>
                                                    <option value="Pasaporte" {{ (old('doc_type') ?? $pilot->doc_type ?? '') == 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                                                    <option value="NIT" {{ (old('doc_type') ?? $pilot->doc_type ?? '') == 'NIT' ? 'selected' : '' }}>NIT</option>
                                                </select>
                                            </div>
                                            <div class="col-md-7 mb-3">
                                                <label class="form-label">Número de Identificación (NUIP/DUI)</label>
                                                <input class="form-control @error('doc_number') is-invalid @enderror" 
                                                    name="doc_number" 
                                                    type="text" 
                                                    value="{{ old('doc_number') ?? $pilot->doc_number ?? '' }}" 
                                                    placeholder="Ej: 00000000-0" 
                                                    required>
                                                @error('doc_number')
                                                    <div class="invalid-feedback">Este número de identificación ya existe.</div>
                                                @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Nombre</label>
                                                <input class="form-control" name="name" type="text" value="{{ $pilot->name }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input class="form-control" name="email" type="email" value="{{ $pilot->email }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">No. Licencia</label>
                                                <input class="form-control" name="license_number" type="text" value="{{ $pilot->license_number }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Vencimiento Médica</label>
                                                <input class="form-control" name="medical_certificate_expiry" type="date" value="{{ $pilot->medical_certificate_expiry }}" required>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Teléfono</label>
                                                <input class="form-control" name="phone" type="text" value="{{ $pilot->phone }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cerrar</button>
                                            <button class="btn btn-primary" type="submit">Actualizar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

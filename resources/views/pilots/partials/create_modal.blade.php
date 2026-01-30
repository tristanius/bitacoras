<div class="modal fade" id="createPilotModal" tabindex="-1" role="dialog" aria-labelledby="createPilotModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Registrar Nuevo Piloto</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('pilots.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
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
                            value="" 
                            placeholder="Ej: 00000000-0" 
                            required>
                        @error('doc_number')
                            <div class="invalid-feedback">Este número de identificación ya existe.</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nombre Completo</label>
                        <input class="form-control" name="name" type="text" value="{{ old('name') }}" placeholder="Ej: Juan Pérez" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input class="form-control" name="email" type="email" value="{{ old('email') }}" placeholder="juan@correo.com" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Licencia</label>
                            <input class="form-control" name="license_number" type="text" value="{{ old('license_number') }}" placeholder="Ej: 12345-P" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Teléfono</label>
                            <input class="form-control" name="phone" type="text" value="{{ old('phone') }}" placeholder="5555-5555">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Vencimiento Certificado Médico</label>
                        <input class="form-control" name="medical_certificate_expiry" type="date" value="{{ old('medical_certificate_expiry') }}" required>
                    </div>
                    
                    <div class="alert alert-light-primary" role="alert">
                        <i class="fa fa-info-circle"></i> La contraseña inicial será el <strong>Número de Licencia</strong>.
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto de Perfil (2Mb max.)</label>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-primary" type="submit">Guardar Piloto</button>
                </div>
            </form>
        </div>
    </div>
</div>
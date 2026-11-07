<div class="mb-3">
    <label class="form-label text-dark small fw-semibold">Nome</label>
    <div class="input-group">
        <span class="input-group-text border-0" style="background-color: #0b132b; color: #D4AF37;">
            <i class="fa-solid fa-tag"></i>
        </span>
        <input type="text" name="nome"
            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('nome') is-invalid @enderror"
            placeholder="Ex: SUV" value="{{ old('nome', $categoria->nome ?? '') }}">
    </div>
    @error('nome')
        <div class="text-danger small mt-1 fw-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
    @enderror
</div>

<div class="mb-3">
    <label class="form-label text-dark small fw-semibold">Descrição <span class="text-muted fw-normal">(opcional)</span></label>
    <textarea name="descricao" rows="3"
        class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('descricao') is-invalid @enderror"
        placeholder="Ex: Utilitários esportivos">{{ old('descricao', $categoria->descricao ?? '') }}</textarea>
    @error('descricao')
        <div class="text-danger small mt-1 fw-medium"><i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}</div>
    @enderror
</div>

<div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
    <a href="{{ route('categorias.index') }}" class="btn btn-light border fw-semibold px-4 py-2 rounded-3 text-secondary">Cancelar</a>
    <button type="submit" class="btn fw-bold text-white px-4 py-2 rounded-3 shadow-sm" style="background-color: #0b132b;">
        <i class="fa-solid fa-floppy-disk me-2" style="color: #D4AF37;"></i>Salvar
    </button>
</div>

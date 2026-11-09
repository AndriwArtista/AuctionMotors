@php
    $categoria = $categoria ?? null;
@endphp

<div class="row g-3">
    <x-campo name="nome" label="Nome da categoria" icon="fa-tag" placeholder="Ex: SUV" col="col-12"
        :value="$categoria?->nome" />

    <div class="col-12 mb-2">
        <label for="descricao" class="form-label text-dark small fw-semibold">
            Descrição <span class="text-muted fw-normal">(opcional)</span>
        </label>
        <textarea id="descricao" name="descricao" rows="4"
            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('descricao') is-invalid @enderror"
            placeholder="Ex: Utilitários esportivos">{{ old('descricao', $categoria?->descricao) }}</textarea>
        @error('descricao')
            <div class="text-danger small mt-1 fw-medium">
                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>
</div>

<div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
    <a href="{{ route('categorias.index') }}" class="btn btn-light border fw-semibold px-4 py-2 rounded-3 text-secondary">
        Cancelar
    </a>
    <button type="submit" class="btn fw-bold text-white px-4 py-2 rounded-3 shadow-sm" style="background-color: #0b132b;">
        <i class="fa-solid fa-floppy-disk me-2" style="color: #D4AF37;"></i>Salvar Categoria
    </button>
</div>

{{-- Formulario compartilhado entre o cadastro e a edicao de veiculo --}}
@php
    $veiculo = $veiculo ?? null;
@endphp

<div class="row g-3">
    <div class="col-12 mb-2">
        <label for="categoria_id" class="form-label text-dark small fw-semibold">Categoria</label>
        <div class="input-group">
            <span class="input-group-text border-0" style="background-color: #0b132b; color: #D4AF37;">
                <i class="fa-solid fa-layer-group"></i>
            </span>
            <select id="categoria_id" name="categoria_id"
                class="form-select bg-light border-0 shadow-none px-3 py-2 text-dark @error('categoria_id') is-invalid @enderror">
                <option value="">Selecione...</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" @selected(old('categoria_id', $veiculo?->categoria_id) == $categoria->id)>
                        {{ $categoria->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        @error('categoria_id')
            <div class="text-danger small mt-1 fw-medium">
                <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
            </div>
        @enderror
    </div>

    <x-campo name="marca" label="Marca" icon="fa-copyright" placeholder="Ex: Toyota" :value="$veiculo?->marca" />
    <x-campo name="modelo" label="Modelo" icon="fa-car" placeholder="Ex: Corolla" :value="$veiculo?->modelo" />
    <x-campo name="ano" label="Ano" icon="fa-calendar" type="number" placeholder="Ex: 2022" :value="$veiculo?->ano" />
    <x-campo name="kilometragem" label="Quilometragem (KM)" icon="fa-gauge-high" type="number" placeholder="Ex: 45000" :value="$veiculo?->kilometragem" />
    <x-campo name="valor_inicial" label="Valor inicial (R$)" icon="fa-sack-dollar" type="number" step="0.01" placeholder="0,00" :value="$veiculo?->valor_inicial" />
    <x-campo name="data_encerramento" label="Encerramento do leilão" icon="fa-clock" type="datetime-local"
        :value="$veiculo?->data_encerramento?->format('Y-m-d\TH:i')" />
</div>

<div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
    <a href="{{ route('veiculos.listar') }}" class="btn btn-light border fw-semibold px-4 py-2 rounded-3 text-secondary">
        Cancelar
    </a>
    <button type="submit" class="btn fw-bold text-white px-4 py-2 rounded-3 shadow-sm" style="background-color: #0b132b;">
        <i class="fa-solid fa-floppy-disk me-2" style="color: #D4AF37;"></i>Salvar Veículo
    </button>
</div>

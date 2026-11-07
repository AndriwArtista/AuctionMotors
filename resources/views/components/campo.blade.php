{{--
    Campo de formulario com icone e mensagem de erro.
    Uso: <x-campo name="marca" label="Marca" icon="fa-copyright" placeholder="Ex: Toyota" :value="$veiculo->marca ?? ''" />
--}}
@props([
    'name',
    'label',
    'icon' => 'fa-pen',
    'type' => 'text',
    'value' => '',
    'col' => 'col-md-6',
])

<div class="{{ $col }} mb-2">
    <label for="{{ $name }}" class="form-label text-dark small fw-semibold">{{ $label }}</label>
    <div class="input-group">
        <span class="input-group-text border-0" style="background-color: #0b132b; color: #D4AF37;">
            <i class="fa-solid {{ $icon }}"></i>
        </span>
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
            {{ $attributes->merge(['class' => 'form-control bg-light border-0 shadow-none px-3 py-2 text-dark' . ($errors->has($name) ? ' is-invalid' : '')]) }}>
    </div>
    @error($name)
        <div class="text-danger small mt-1 fw-medium">
            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
        </div>
    @enderror
</div>

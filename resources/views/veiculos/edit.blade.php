@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border border-light-subtle shadow-lg rounded-4 overflow-hidden bg-white">
                    <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);"></div>

                    <div class="card-body p-4 p-sm-5">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <div>
                                <h3 class="fw-bold mb-1" style="color: #0b132b;">Editar Veículo</h3>
                                <p class="text-secondary small mb-0">Atualize as informações do lote no leilão</p>
                            </div>
                            <div class="rounded-circle p-3 d-flex align-items-center justify-content-center"
                                style="background-color: #f8f9fa;">
                                <i class="fa-solid fa-pen-to-square fa-xl" style="color: #D4AF37;"></i>
                            </div>
                        </div>

                        <form action="{{ route('veiculos.update', $id) }}" method="POST" novalidate>
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-dark small fw-semibold">Marca</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"
                                            style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid fa-copyright"></i>
                                        </span>
                                        <input type="text" name="marca"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('marca') is-invalid @enderror"
                                            value="{{ old('marca', $veiculo->marca) }}">
                                    </div>
                                    @error('marca')
                                        <div class="text-danger small mt-1 fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-dark small fw-semibold">Modelo</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"
                                            style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid fa-car"></i>
                                        </span>
                                        <input type="text" name="modelo"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('modelo') is-invalid @enderror"
                                            value="{{ old('modelo', $veiculo->modelo) }}">
                                    </div>
                                    @error('modelo')
                                        <div class="text-danger small mt-1 fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-dark small fw-semibold">Ano</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"
                                            style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid fa-calendar"></i>
                                        </span>
                                        <input type="number" name="ano"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('ano') is-invalid @enderror"
                                            value="{{ old('ano', $veiculo->ano) }}">
                                    </div>
                                    @error('ano')
                                        <div class="text-danger small mt-1 fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-dark small fw-semibold">Quilometragem (KM)</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"
                                            style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid fa-gauge-high"></i>
                                        </span>
                                        <input type="number" name="kilometragem"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('kilometragem') is-invalid @enderror"
                                            value="{{ old('kilometragem', $veiculo->kilometragem) }}">
                                    </div>
                                    @error('kilometragem')
                                        <div class="text-danger small mt-1 fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-dark small fw-semibold">Valor inicial (R$)</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"
                                            style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid fa-sack-dollar"></i>
                                        </span>
                                        <input type="number" step="0.01" name="valor_inicial"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('valor_inicial') is-invalid @enderror"
                                            value="{{ old('valor_inicial', $veiculo->valor_inicial) }}">
                                    </div>
                                    @error('valor_inicial')
                                        <div class="text-danger small mt-1 fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-2">
                                    <label class="form-label text-dark small fw-semibold">Encerramento do leilão</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0"
                                            style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid fa-clock"></i>
                                        </span>
                                        <input type="datetime-local" name="data_encerramento"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error('data_encerramento') is-invalid @enderror"
                                            value="{{ old('data_encerramento', $veiculo->data_encerramento->format('Y-m-d\TH:i')) }}">
                                    </div>
                                    @error('data_encerramento')
                                        <div class="text-danger small mt-1 fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-end gap-2 mt-4 pt-3 border-top">
                                <a href="{{ route('veiculos.index') }}"
                                    class="btn btn-light border fw-semibold px-4 py-2 rounded-3 text-secondary">
                                    Cancelar
                                </a>
                                <button type="submit" class="btn fw-bold text-white px-4 py-2 rounded-3 shadow-sm"
                                    style="background-color: #0b132b;">
                                    <i class="fa-solid fa-arrows-rotate me-2" style="color: #D4AF37;"></i>Atualizar Veículo
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
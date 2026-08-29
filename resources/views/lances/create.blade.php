@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>

        <div class="mb-4">
            <a href="{{ route('veiculos.index') }}"
                class="btn btn-light border fw-semibold rounded-3 text-secondary shadow-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Voltar para os Leilões
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success border-0 shadow-sm rounded-3 mb-4">
                <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
            </div>
        @endif

        <div class="row g-4">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-body p-4 p-sm-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3 py-1">
                                <i class="fa-solid fa-tag me-1"></i>{{ $veiculo->status }}
                            </span>
                            <span class="text-muted small">
                                <i class="fa-solid fa-clock me-1" style="color: #D4AF37;"></i>
                                Encerra em: {{ \Carbon\Carbon::parse($veiculo->data_encerramento)->format('d/m/Y H:i') }}
                            </span>
                        </div>

                        <h2 class="fw-bold mb-1" style="color: #0b132b;">
                            {{ $veiculo->marca }} {{ $veiculo->modelo }}
                        </h2>
                        <p class="text-secondary small mb-4">Ano {{ $veiculo->ano }} •
                            {{ number_format($veiculo->kilometragem, 0, ',', '.') }} KM
                        </p>

                        @php
                            $maiorLance = $lances->max('valor_ofertado') ?? $veiculo->valor_inicial;
                            $minLance = $maiorLance + 0.01;
                        @endphp

                        <div class="p-4 rounded-4 mb-4" style="background-color: #f8f9fa; border-left: 5px solid #D4AF37;">
                            <div class="row text-center text-sm-start">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <span class="text-secondary small d-block mb-1">Valor Inicial</span>
                                    <span class="fs-5 fw-semibold text-dark">
                                        R$ {{ number_format($veiculo->valor_inicial, 2, ',', '.') }}
                                    </span>
                                </div>
                                <div class="col-sm-6">
                                    <span class="text-secondary small d-block mb-1">Última Oferta / Lance Atual</span>
                                    <span class="fs-3 fw-bold" style="color: #0b132b;">
                                        R$ {{ number_format($maiorLance, 2, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('lances.store', \App\Services\Operations::encryptId($veiculo->id)) }}"
                            method="POST">
                            @csrf
                            <label class="form-label text-dark small fw-semibold">Seu Lance (Mínimo: R$
                                {{ number_format($minLance, 2, ',', '.') }})</label>
                            <div class="input-group mb-2">
                                <span class="input-group-text border-0" style="background-color: #0b132b; color: #D4AF37;">
                                    R$
                                </span>
                                <input type="number" step="0.01" min="{{ $minLance }}" name="valor_ofertado"
                                    class="form-control bg-light border-0 shadow-none px-3 py-2-5 text-dark @error('valor_ofertado') is-invalid @enderror"
                                    placeholder="{{ number_format($minLance, 2, ',', '.') }}" required>
                            </div>
                            @error('valor_ofertado')
                                <div class="text-danger small mb-3 fw-medium">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="btn w-100 fw-bold py-3 mt-3 rounded-3 shadow-sm text-white"
                                style="background-color: #0b132b; letter-spacing: 0.5px;">
                                <i class="fa-solid fa-gavel me-2" style="color: #D4AF37;"></i> Confirmar Lance
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Histórico de Lances (Design Limpo e Moderno) -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 bg-white h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold m-0" style="color: #0b132b;">Histórico</h5>
                            <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                {{ count($lances) }} {{ count($lances) === 1 ? 'lance' : 'lances' }}
                            </span>
                        </div>

                        <div class="d-flex flex-column gap-2" style="max-height: 420px; overflow-y: auto;">
                            @forelse($lances as $index => $lance)
                                <div
                                    class="p-3 rounded-3 d-flex justify-content-between align-items-center {{ $loop->first ? 'bg-light border-start border-4 border-warning' : 'bg-body-tertiary' }}">
                                    <div>
                                        <div class="fw-semibold text-dark small mb-1">
                                            {{ $lance->nome_licitante }}
                                            @if($loop->first)
                                                <span class="badge bg-warning text-dark ms-1"
                                                    style="font-size: 0.65rem;">Maior</span>
                                            @endif
                                        </div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            {{ \Carbon\Carbon::parse($lance->created_at)->format('d/m/Y H:i') }}
                                        </div>
                                    </div>
                                    <span class="fw-bold {{ $loop->first ? 'text-dark fs-6' : 'text-secondary small' }}">
                                        R$ {{ number_format($lance->valor_ofertado, 2, ',', '.') }}
                                    </span>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <p class="text-secondary small mb-1">Sem ofertas no momento.</p>
                                    <span class="text-muted extra-small" style="font-size: 0.8rem;">Faça o primeiro lance
                                        acima.</span>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
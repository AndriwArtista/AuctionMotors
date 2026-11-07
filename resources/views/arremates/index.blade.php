@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>

        <div class="mb-4 pb-2 border-bottom">
            <h2 class="fw-bold mb-1" style="color: #0b132b;">Meus Arremates</h2>
            <p class="text-secondary small mb-0">Leilões que você venceu</p>
        </div>

        <div class="row g-4">
            @forelse($arremates as $arremate)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <div class="card-header bg-light border-0 d-flex justify-content-between align-items-center px-4 pt-3 pb-2">
                            <span class="badge bg-success rounded-pill px-3 py-1">
                                <i class="fa-solid fa-trophy me-1"></i>Arrematado
                            </span>
                            <span class="text-muted small">{{ $arremate->encerrado_em->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="card-body px-4">
                            <h5 class="fw-bold mb-1" style="color: #0b132b;">
                                {{ $arremate->veiculo->marca }} {{ $arremate->veiculo->modelo }}
                            </h5>
                            <p class="text-muted small mb-3">
                                {{ $arremate->veiculo->categoria->nome ?? 'Sem categoria' }} •
                                Ano {{ $arremate->veiculo->ano }} •
                                Vendedor: {{ $arremate->veiculo->user->nome ?? '—' }}
                            </p>
                            <div class="p-3 rounded-3 mb-3" style="background-color: #f8f9fa; border-left: 4px solid #D4AF37;">
                                <span class="text-secondary small d-block">Valor final</span>
                                <span class="fs-4 fw-bold" style="color: #0b132b;">
                                    R$ {{ number_format($arremate->valor_final, 2, ',', '.') }}
                                </span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="{{ route('lances.create', $arremate->encrypted_veiculo_id) }}"
                                    class="btn btn-light border w-100 fw-semibold rounded-3 text-secondary">
                                    <i class="fa-solid fa-eye me-1"></i> Ver leilão
                                </a>
                                <a href="{{ route('relatorios.arremate', \App\Services\Operations::encryptId($arremate->id)) }}"
                                    class="btn w-100 fw-bold rounded-3 text-white shadow-sm" style="background-color: #0b132b;">
                                    <i class="fa-solid fa-file-pdf me-1" style="color: #D4AF37;"></i> Comprovante
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                        <i class="fa-solid fa-trophy fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h5 class="text-secondary">Você ainda não venceu nenhum leilão.</h5>
                        <p class="text-muted small">Dê lances na vitrine e acompanhe por aqui.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection

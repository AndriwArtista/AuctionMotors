@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>

        <div class="d-flex justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0b132b;">Meus Veículos Cadastrados</h2>
                <p class="text-secondary small mb-0">Gerencie os lotes que você colocou em leilão</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('veiculos.index') }}"
                    class="btn btn-light border fw-semibold rounded-3 text-secondary shadow-sm">
                    <i class="fa-solid fa-arrow-left me-1"></i> Voltar
                </a>
                <a href="{{ route('veiculos.create') }}" class="btn fw-bold text-white shadow-sm"
                    style="background-color: #0b132b;">
                    <i class="fa-solid fa-plus me-1" style="color: #D4AF37;"></i> Novo Veículo
                </a>
            </div>
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
            @forelse($veiculos as $veiculo)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <div
                            class="card-header bg-light border-0 d-flex justify-content-between align-items-center px-4 pt-3 pb-2">
                            <span class="badge bg-secondary-subtle text-secondary border rounded-pill px-3 py-1">
                                <i class="fa-solid fa-tag me-1"></i>{{ $veiculo->status }}
                            </span>
                            <span class="text-muted small">
                                <i
                                    class="fa-solid fa-gauge-high me-1"></i>{{ number_format($veiculo->kilometragem, 0, ',', '.') }}
                                km
                            </span>
                        </div>

                        <div class="card-body px-4">
                            <h5 class="fw-bold mb-1" style="color: #0b132b;">
                                {{ $veiculo->marca }} {{ $veiculo->modelo }}
                            </h5>
                            <p class="text-muted small mb-3">Ano: <strong>{{ $veiculo->ano }}</strong></p>

                            <div class="p-3 rounded-3 mb-3" style="background-color: #f8f9fa; border-left: 4px solid #D4AF37;">
                                <span class="text-secondary small d-block">Valor Inicial Cadastrado</span>
                                <span class="fs-4 fw-bold" style="color: #0b132b;">
                                    R$ {{ number_format($veiculo->valor_inicial, 2, ',', '.') }}
                                </span>
                            </div>

                            <div class="d-flex gap-2">
                                <a href="{{ route('veiculos.edit', $veiculo->encrypted_id) }}"
                                    class="btn w-100 fw-bold py-2 rounded-3 text-white shadow-sm"
                                    style="background-color: #0b132b;">
                                    <i class="fa-solid fa-pen-to-square me-1" style="color: #D4AF37;"></i> Editar
                                </a>

                                <form action="{{ route('veiculos.destroy', $veiculo->encrypted_id) }}" method="POST"
                                    class="w-100" onsubmit="return confirm('Tem certeza que deseja excluir este veículo?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger w-100 fw-bold py-2 rounded-3">
                                        <i class="fa-solid fa-trash me-1"></i> Excluir
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                        <i class="fa-solid fa-car-rear fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                        <h5 class="text-secondary">Você ainda não cadastrou nenhum veículo.</h5>
                        <p class="text-muted small">Clique no botão acima para adicionar seu primeiro lote ao leilão.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
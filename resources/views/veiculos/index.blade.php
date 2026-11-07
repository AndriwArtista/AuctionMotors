@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>
        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0b132b;">Veículos em Leilão</h2>
                <p class="text-secondary small mb-0">Confira os lotes disponíveis e faça seu lance</p>
            </div>
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('veiculos.create') }}" class="btn fw-bold text-white shadow-sm"
                    style="background-color: #0b132b;">
                    <i class="fa-solid fa-plus me-1" style="color: #D4AF37;"></i> Novo Veículo
                </a>
                <a href="{{ route('veiculos.listar') }}" class="btn fw-bold text-white shadow-sm"
                    style="background-color: #0b132b;">
                    <i class="fa-solid fa-car me-1" style="color: #D4AF37;"></i> Meus Veículos
                </a>
                <a href="{{ route('relatorios.veiculos', array_filter(['categoria' => $categoriaSelecionada])) }}" target="_blank" class="btn fw-bold text-white shadow-sm"
                    style="background-color: #0b132b;">
                    <i class="fa-solid fa-file-pdf me-1" style="color: #D4AF37;"></i> Relatório PDF
                </a>
            </div>
        </div>
        <form method="GET" action="{{ route('veiculos.index') }}" class="row g-2 align-items-center mb-4">
            <div class="col-auto">
                <label for="filtroCategoria" class="col-form-label small fw-semibold text-secondary">
                    <i class="fa-solid fa-filter me-1" style="color: #D4AF37;"></i>Categoria
                </label>
            </div>
            <div class="col-auto">
                <select id="filtroCategoria" name="categoria" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">Todas</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}" @selected($categoriaSelecionada == $categoria->id)>{{ $categoria->nome }}</option>
                    @endforeach
                </select>
            </div>
            @if($categoriaSelecionada)
                <div class="col-auto">
                    <a href="{{ route('veiculos.index') }}" class="btn btn-sm btn-link text-secondary">Limpar filtro</a>
                </div>
            @endif
        </form>

        <x-flash />

        <div class="row g-4">
            @forelse($veiculos as $veiculo)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden bg-white">
                        <div
                            class="card-header bg-light border-0 d-flex justify-content-between align-items-center px-4 pt-3 pb-2">
                            <x-status-badge :status="$veiculo->status" />
                            <span class="text-muted small">
                                <i class="fa-solid fa-layer-group me-1" style="color: #D4AF37;"></i>{{ $veiculo->categoria->nome ?? 'Sem categoria' }}
                            </span>
                        </div>
                        <div class="card-body px-4">
                            <h5 class="fw-bold mb-1" style="color: #0b132b;">
                                {{ $veiculo->marca }} {{ $veiculo->modelo }}
                            </h5>
                            <p class="text-muted small mb-3">Ano: <strong>{{ $veiculo->ano }}</strong></p>
                            <div class="p-3 rounded-3 mb-3" style="background-color: #f8f9fa; border-left: 4px solid #D4AF37;">
                                @if($veiculo->status === 'encerrado')
                                    <span class="text-secondary small d-block">
                                        {{ $veiculo->arremate?->user ? 'Arrematado por ' . $veiculo->arremate->user->nome : 'Encerrado sem lances' }}
                                    </span>
                                @else
                                    <span class="text-secondary small d-block">
                                        {{ $veiculo->lances_max_valor_ofertado ? 'Último Lance' : 'Valor Inicial' }}
                                    </span>
                                @endif
                                <span class="fs-4 fw-bold" style="color: #0b132b;">
                                    R$ {{ number_format($veiculo->valor_atual, 2, ',', '.') }}
                                </span>
                                @if($veiculo->status === 'aberto')
                                    <span class="d-block text-muted small mt-1">
                                        <i class="fa-solid fa-clock me-1"></i>Encerra {{ $veiculo->data_encerramento->format('d/m/Y H:i') }}
                                    </span>
                                @endif
                            </div>
                            <a href="{{ route('lances.create', $veiculo->encrypted_id) }}"
                                class="btn w-100 fw-bold py-2 rounded-3 shadow-sm text-white"
                                style="background-color: #0b132b;">
                                @if($veiculo->status === 'aberto')
                                    <i class="fa-solid fa-gavel me-2" style="color: #D4AF37;"></i>Dar Lance
                                @else
                                    <i class="fa-solid fa-eye me-2" style="color: #D4AF37;"></i>Ver Resultado
                                @endif
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                        <h5 class="text-secondary">Nenhum veículo cadastrado no leilão ainda.</h5>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Links de Paginação -->
        <div class="d-flex justify-content-center mt-5">
            {{ $veiculos->links() }}
        </div>
    </div>
@endsection
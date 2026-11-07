@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5" style="max-width: 860px;">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>

        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0b132b;">Notificações</h2>
                <p class="text-secondary small mb-0">Acompanhe os lances e o resultado dos leilões</p>
            </div>
            <form action="{{ route('notificacoes.marcarTodas') }}" method="POST" class="m-0">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-light border fw-semibold rounded-3 text-secondary shadow-sm">
                    <i class="fa-solid fa-check-double me-1"></i> Marcar todas como lidas
                </button>
            </form>
        </div>

        <x-flash />
<div class="d-flex flex-column gap-2">
            @forelse($notificacoes as $notificacao)
                <div class="card border-0 shadow-sm rounded-3 {{ $notificacao->lida_em ? 'opacity-75' : 'border-start border-4 border-' . $notificacao->cor() }}">
                    <div class="card-body d-flex align-items-center gap-3 py-3">
                        <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 bg-{{ $notificacao->cor() }}-subtle text-{{ $notificacao->cor() }}"
                            style="width: 42px; height: 42px;">
                            <i class="fa-solid {{ $notificacao->icone() }}"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="{{ $notificacao->lida_em ? 'text-secondary' : 'fw-semibold text-dark' }}">{{ $notificacao->mensagem }}</div>
                            <small class="text-muted">{{ $notificacao->created_at->format('d/m/Y H:i') }}</small>
                        </div>
                        <div class="d-flex gap-2 flex-shrink-0">
                            @if($notificacao->encrypted_veiculo_id)
                                <a href="{{ route('lances.create', $notificacao->encrypted_veiculo_id) }}" class="btn btn-sm btn-light border" title="Ver leilão">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                            @endif
                            @unless($notificacao->lida_em)
                                <form action="{{ route('notificacoes.marcarLida', \App\Services\Operations::encryptId($notificacao->id)) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm text-white" style="background-color: #0b132b;" title="Marcar como lida">
                                        <i class="fa-solid fa-check" style="color: #D4AF37;"></i>
                                    </button>
                                </form>
                            @endunless
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                    <i class="fa-solid fa-bell-slash fa-3x text-muted mb-3" style="opacity: 0.3;"></i>
                    <h5 class="text-secondary">Nenhuma notificação por enquanto.</h5>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $notificacoes->links() }}
        </div>
    </div>
@endsection

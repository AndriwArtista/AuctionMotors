<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3 mb-4">
    <a class="navbar-brand fw-bold" href="{{ route('veiculos.index') }}">
        <i class="fa-solid fa-gavel me-1" style="color: #D4AF37;"></i> Auction Motors
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menuPrincipal"
        aria-controls="menuPrincipal" aria-expanded="false" aria-label="Abrir menu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="menuPrincipal">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('veiculos.index') ? 'active' : '' }}" href="{{ route('veiculos.index') }}">Leilões</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('veiculos.listar') ? 'active' : '' }}" href="{{ route('veiculos.listar') }}">Meus veículos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('arremates.*') ? 'active' : '' }}" href="{{ route('arremates.index') }}">Meus arremates</a>
            </li>
            @if(session('user.is_admin'))
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('categorias.*') ? 'active' : '' }}" href="{{ route('categorias.index') }}">
                        <i class="fa-solid fa-shield-halved me-1" style="color: #D4AF37;"></i>Categorias
                    </a>
                </li>
            @endif
        </ul>

        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('notificacoes.index') }}" class="position-relative text-light" title="Notificações">
                <i class="fa-solid fa-bell fa-lg"></i>
                @if($notificacoesNaoLidas > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                        {{ $notificacoesNaoLidas > 9 ? '9+' : $notificacoesNaoLidas }}
                    </span>
                @endif
            </a>
            <span class="text-light small"><i class="fa-solid fa-user me-1" style="color: #D4AF37;"></i>{{ session('user.nome') }}</span>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
            </form>
        </div>
    </div>
</nav>

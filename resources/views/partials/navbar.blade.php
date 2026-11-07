<nav class="navbar navbar-dark bg-dark px-3 mb-4">
    <a class="navbar-brand" href="{{ route('veiculos.index') }}">Auction Motors</a>
    <form action="{{ route('logout') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="btn btn-outline-light btn-sm">Sair</button>
    </form>
</nav>

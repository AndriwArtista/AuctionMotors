@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>

        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4 pb-2 border-bottom">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0b132b;">Categorias</h2>
                <p class="text-secondary small mb-0">Organize os veículos do leilão por tipo</p>
            </div>
            <a href="{{ route('categorias.create') }}" class="btn fw-bold text-white shadow-sm" style="background-color: #0b132b;">
                <i class="fa-solid fa-plus me-1" style="color: #D4AF37;"></i> Nova Categoria
            </a>
        </div>

        <x-flash />

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">Nome</th>
                            <th>Descrição</th>
                            <th class="text-center">Veículos</th>
                            <th class="text-end px-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            @php $cid = \App\Services\Operations::encryptId($categoria->id); @endphp
                            <tr>
                                <td class="px-4 fw-semibold" style="color: #0b132b;">{{ $categoria->nome }}</td>
                                <td class="text-secondary small">{{ $categoria->descricao ?? '—' }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill bg-secondary-subtle text-secondary border">{{ $categoria->veiculos_count }}</span>
                                </td>
                                <td class="text-end px-4">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('categorias.edit', $cid) }}" class="btn btn-sm text-white" style="background-color: #0b132b;">
                                            <i class="fa-solid fa-pen-to-square" style="color: #D4AF37;"></i>
                                        </a>
                                        <form action="{{ route('categorias.destroy', $cid) }}" method="POST"
                                            onsubmit="return confirm('Excluir a categoria {{ $categoria->nome }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-secondary py-5">Nenhuma categoria cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

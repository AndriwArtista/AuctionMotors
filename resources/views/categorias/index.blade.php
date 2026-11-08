@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5" style="max-width: 960px;">
        <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);" class="rounded mb-4"></div>

        <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1" style="color: #0b132b;">Categorias</h2>
                <p class="text-secondary mb-0">
                    {{ $categorias->count() }} {{ $categorias->count() === 1 ? 'categoria cadastrada' : 'categorias cadastradas' }}
                </p>
            </div>
            <a href="{{ route('categorias.create') }}" class="btn btn-lg fw-bold text-white shadow-sm px-4" style="background-color: #0b132b;">
                <i class="fa-solid fa-plus me-2" style="color: #D4AF37;"></i>Nova Categoria
            </a>
        </div>

        <x-flash />

        @forelse($categorias as $categoria)
            @php
                $cid = \App\Services\Operations::encryptId($categoria->id);
                $total = $categoria->veiculos_count;
            @endphp

            <div class="card border shadow-sm rounded-4 mb-3" style="border-left: 5px solid #D4AF37 !important;">
                <div class="card-body p-4 d-flex flex-column flex-md-row gap-3 align-items-md-center">
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1" style="color: #0b132b;">{{ $categoria->nome }}</h5>
                        <p class="mb-2 text-body">{{ $categoria->descricao ?: 'Sem descrição.' }}</p>
                        <span class="badge rounded-pill fs-6 fw-semibold px-3 py-2"
                            style="background-color: #f3ead2; color: #6b4e0f;">
                            <i class="fa-solid fa-car me-1"></i>{{ $total }} {{ $total === 1 ? 'veículo' : 'veículos' }}
                        </span>
                    </div>

                    <div class="d-flex gap-2 flex-shrink-0">
                        <a href="{{ route('categorias.edit', $cid) }}" class="btn fw-semibold text-white px-3" style="background-color: #0b132b;">
                            <i class="fa-solid fa-pen-to-square me-1" style="color: #D4AF37;"></i>Editar
                        </a>

                        @if($total > 0)
                            <span class="d-inline-block" tabindex="0" title="Não dá pra excluir: existem veículos nessa categoria">
                                <button type="button" class="btn btn-outline-secondary fw-semibold px-3" disabled>
                                    <i class="fa-solid fa-trash me-1"></i>Excluir
                                </button>
                            </span>
                        @else
                            <form action="{{ route('categorias.destroy', $cid) }}" method="POST"
                                onsubmit="return confirm('Excluir a categoria {{ $categoria->nome }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger fw-semibold px-3">
                                    <i class="fa-solid fa-trash me-1"></i>Excluir
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                <i class="fa-solid fa-layer-group fa-2x mb-3" style="color: #D4AF37;"></i>
                <h5 class="fw-bold" style="color: #0b132b;">Nenhuma categoria cadastrada</h5>
                <p class="text-secondary mb-0">Clique em "Nova Categoria" para começar.</p>
            </div>
        @endforelse
    </div>
@endsection

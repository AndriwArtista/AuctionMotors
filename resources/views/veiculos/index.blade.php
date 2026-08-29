@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Veículos em leilão</h2>
            <a href="{{ route('veiculos.create') }}" class="btn btn-primary">+ Novo veículo</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Ano</th>
                    <th>Valor inicial</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($veiculos as $veiculo)
                    <tr>
                        <td>{{ $veiculo->marca }}</td>
                        <td>{{ $veiculo->modelo }}</td>
                        <td>{{ $veiculo->ano }}</td>
                        <td>R$ {{ number_format($veiculo->valor_inicial, 2, ',', '.') }}</td>
                        <td>{{ $veiculo->status }}</td>
                        <td>
                            <a href="{{ route('veiculos.edit', $veiculo->encrypted_id) }}" class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('veiculos.destroy', $veiculo->encrypted_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Excluir este veículo?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Nenhum veículo cadastrado ainda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
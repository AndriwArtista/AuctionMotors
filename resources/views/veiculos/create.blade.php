@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container">
        <h2>Novo veículo</h2>
        <form action="{{ route('veiculos.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Marca</label>
                <input type="text" name="marca" class="form-control @error('marca') is-invalid @enderror" value="{{ old('marca') }}">
                @error('marca') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Modelo</label>
                <input type="text" name="modelo" class="form-control @error('modelo') is-invalid @enderror" value="{{ old('modelo') }}">
                @error('modelo') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Ano</label>
                <input type="number" name="ano" class="form-control @error('ano') is-invalid @enderror" value="{{ old('ano') }}">
                @error('ano') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Kilometragem</label>
                <input type="number" name="kilometragem" class="form-control @error('kilometragem') is-invalid @enderror" value="{{ old('kilometragem') }}">
                @error('kilometragem') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Valor inicial (R$)</label>
                <input type="number" step="0.01" name="valor_inicial" class="form-control @error('valor_inicial') is-invalid @enderror" value="{{ old('valor_inicial') }}">
                @error('valor_inicial') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label>Data de encerramento do leilão</label>
                <input type="datetime-local" name="data_encerramento" class="form-control @error('data_encerramento') is-invalid @enderror" value="{{ old('data_encerramento') }}">
                @error('data_encerramento') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="{{ route('veiculos.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
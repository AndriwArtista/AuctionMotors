@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card border border-light-subtle shadow-lg rounded-4 overflow-hidden bg-white">
                    <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);"></div>

                    <div class="card-body p-4 p-sm-5">
                        <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom">
                            <div>
                                <h3 class="fw-bold mb-1" style="color: #0b132b;">Novo Veículo</h3>
                                <p class="text-secondary small mb-0">Cadastre os detalhes do lote para o leilão</p>
                            </div>
                            <div class="rounded-circle p-3 d-flex align-items-center justify-content-center"
                                style="background-color: #f8f9fa;">
                                <i class="fa-solid fa-car-side fa-xl" style="color: #D4AF37;"></i>
                            </div>
                        </div>

                        <form action="{{ route('veiculos.store') }}" method="POST" novalidate>
                            @csrf
                            @include('veiculos._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

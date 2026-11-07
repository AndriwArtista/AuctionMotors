@extends('layout.main_layout')

@section('content')
    @include('partials.navbar')

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border border-light-subtle shadow-lg rounded-4 overflow-hidden bg-white">
                    <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);"></div>
                    <div class="card-body p-4 p-sm-5">
                        <h3 class="fw-bold mb-4 pb-3 border-bottom" style="color: #0b132b;">Nova Categoria</h3>
                        <form action="{{ route('categorias.store') }}" method="POST" novalidate>
                            @csrf

                            @include('categorias._form')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

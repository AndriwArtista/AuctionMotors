@extends('layout.main_layout')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card border border-light-subtle shadow-lg rounded-4 overflow-hidden bg-white">
                    <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);"></div>
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-4">
                            <img src="assets/images/logo.png" alt="Notes Logo" style="max-height: 200px;" class="img-fluid">
                            <h4 class="fw-bold mb-1" style="color: #0b132b; letter-spacing: 0.5px;">Seja Bem-vindo</h4>
                            <p class="text-secondary small mb-0">Insira suas credenciais para continuar</p>
                        </div>
                        <form action="{{ route('login.submit') }}" method="POST" novalidate>
                            @csrf

                            <div class="mb-4">
                                <label for="text_email" class="form-label text-dark small fw-semibold">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0"
                                        style="background-color: #0b132b; color: #D4AF37;">
                                        <i class="fa-solid fa-user"></i>
                                    </span>
                                    <input type="email"
                                        class="form-control bg-light border-0 shadow-none px-3 py-2-5 text-dark"
                                        name="text_email" placeholder="Digite seu e-mail" value="{{ old('text_email') }}">
                                </div>
                                @error('text_email')
                                    <div class="text-danger small mt-1 d-flex align-items-center fw-medium">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="text_senha" class="form-label text-dark small fw-semibold">Senha</label>
                                <div class="input-group">
                                    <span class="input-group-text border-0"
                                        style="background-color: #0b132b; color: #D4AF37;">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password"
                                        class="form-control bg-light border-0 shadow-none px-3 py-2-5 text-dark"
                                        name="text_senha" placeholder="Digite sua senha" value="{{ old('text_senha') }}">
                                </div>
                                @error('text_senha')
                                    <div class="text-danger small mt-1 d-flex align-items-center fw-medium">
                                        <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3 pt-2">
                                <button type="submit" class="btn w-100 fw-bold text-white py-2-5 rounded-3 shadow-sm"
                                    style="background-color: #0b132b; letter-spacing: 1px; ">
                                    <i class="fa-solid fa-right-to-bracket me-2" style="color: #D4AF37;"></i>LOGIN
                                </button>
                            </div>
                        </form>
                        @if(session('login_error'))
                            <div class="alert alert-danger border-0 text-center rounded-3 mb-0 mt-4 small p-3 shadow-sm">
                                <i class="fa-solid fa-circle-xmark me-1"></i> {{ session('login_error') }}
                            </div>
                        @endif

                    </div>

                    <div class="card-footer border-top border-light-subtle text-center py-3 bg-light">
                        <small class="text-muted">&copy; {{ date('Y') }} Todos os direitos reservados.</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
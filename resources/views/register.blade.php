@extends('layout.main_layout')

@section('content')
    <div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <div class="row justify-content-center w-100">
            <div class="col-lg-5 col-md-7 col-sm-10">
                <div class="card border border-light-subtle shadow-lg rounded-4 overflow-hidden bg-white">
                    <div style="height: 4px; background: linear-gradient(90deg, #aa771c, #ffd700, #c5a059);"></div>
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/images/logo.png') }}" alt="AuctionMotors" style="max-height: 140px;" class="img-fluid">
                            <h4 class="fw-bold mb-1" style="color: #0b132b; letter-spacing: 0.5px;">Criar conta</h4>
                            <p class="text-secondary small mb-0">Cadastre-se para anunciar e dar lances</p>
                        </div>

                        <form action="{{ route('register.submit') }}" method="POST" novalidate>
                            @csrf

                            @foreach ([
                                ['nome', 'Nome', 'text', 'fa-user', 'Como você quer ser chamado'],
                                ['email', 'E-mail', 'email', 'fa-envelope', 'Digite seu e-mail'],
                                ['senha', 'Senha', 'password', 'fa-key', 'Mínimo de 6 caracteres'],
                                ['senha_confirmation', 'Confirmar senha', 'password', 'fa-key', 'Repita a senha'],
                            ] as [$campo, $label, $tipo, $icone, $placeholder])
                                <div class="mb-3">
                                    <label for="{{ $campo }}" class="form-label text-dark small fw-semibold">{{ $label }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text border-0" style="background-color: #0b132b; color: #D4AF37;">
                                            <i class="fa-solid {{ $icone }}"></i>
                                        </span>
                                        <input type="{{ $tipo }}" id="{{ $campo }}" name="{{ $campo }}"
                                            class="form-control bg-light border-0 shadow-none px-3 py-2 text-dark @error($campo) is-invalid @enderror"
                                            placeholder="{{ $placeholder }}"
                                            value="{{ $tipo === 'password' ? '' : old($campo) }}">
                                    </div>
                                    @error($campo)
                                        <div class="text-danger small mt-1 d-flex align-items-center fw-medium">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            @endforeach

                            <div class="mb-3 pt-2">
                                <button type="submit" class="btn w-100 fw-bold text-white py-2 rounded-3 shadow-sm"
                                    style="background-color: #0b132b; letter-spacing: 1px;">
                                    <i class="fa-solid fa-user-plus me-2" style="color: #D4AF37;"></i>CADASTRAR
                                </button>
                            </div>
                        </form>

                        <p class="text-center small mb-0">
                            Já tem conta? <a href="{{ route('login') }}" class="fw-semibold" style="color: #aa771c;">Entrar</a>
                        </p>
                    </div>

                    <div class="card-footer border-top border-light-subtle text-center py-3 bg-light">
                        <small class="text-muted">&copy; {{ date('Y') }} Todos os direitos reservados.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Badge do status do leilao. Uso: <x-status-badge :status="$veiculo->status" /> --}}
@props(['status'])

@php
    $aberto = $status === 'aberto';
@endphp

<span {{ $attributes->merge(['class' => 'badge rounded-pill px-3 py-1 border ' . ($aberto ? 'bg-success-subtle text-success border-success-subtle' : 'bg-dark text-white border-dark')]) }}>
    <i class="fa-solid {{ $aberto ? 'fa-lock-open' : 'fa-lock' }} me-1"></i>{{ ucfirst($status) }}
</span>

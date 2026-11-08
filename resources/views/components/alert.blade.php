@props(['type' => 'success'])

@php
    $icones = [
        'success' => 'fa-circle-check',
        'danger' => 'fa-circle-exclamation',
        'warning' => 'fa-triangle-exclamation',
        'info' => 'fa-circle-info',
    ];
@endphp

<div {{ $attributes->merge(['class' => "alert alert-{$type} alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4"]) }} role="alert">
    <i class="fa-solid {{ $icones[$type] ?? 'fa-circle-info' }} me-2"></i>{{ $slot }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>

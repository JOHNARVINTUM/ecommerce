@props([
    'type' => 'button',
    'variant' => 'primary',
])

@php
    $base = 'inline-flex items-center justify-center rounded-xl px-4 py-2.5 text-sm font-semibold transition';
    $styles = [
        'primary' => 'bg-slate-900 text-white hover:bg-slate-800',
        'secondary' => 'border border-slate-300 bg-white text-slate-700 hover:bg-slate-50',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700',
        'danger' => 'bg-rose-600 text-white hover:bg-rose-700',
    ];
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $base . ' ' . ($styles[$variant] ?? $styles['primary'])]) }}>
    {{ $slot }}
</button>
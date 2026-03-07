@props(['status' => 'pending'])

@php
    $classes = match($status) {
        'successful', 'paid', 'active' => 'bg-emerald-100 text-emerald-700',
        'in_progress', 'pending' => 'bg-amber-100 text-amber-700',
        'cancelled', 'failed', 'inactive' => 'bg-rose-100 text-rose-700',
        default => 'bg-slate-100 text-slate-700',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex rounded-full px-3 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ str_replace('_', ' ', ucfirst($status)) }}
</span>
@props(['status' => 'pending'])

@php
    $classes = match($status) {
        'successful', 'completed', 'paid', 'active' => 'bg-emerald-500/20 text-emerald-300',
        'confirmed' => 'bg-sky-500/20 text-sky-300',
        'in_progress', 'pending', 'unpaid' => 'bg-amber-500/20 text-amber-300',
        'cancelled', 'failed', 'inactive', 'refunded' => 'bg-rose-500/20 text-rose-300',
        default => 'bg-white/10 text-white/80',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex rounded-full px-3 py-1 text-xs font-semibold {$classes}"]) }}>
    {{ str_replace('_', ' ', ucfirst($status)) }}
</span>

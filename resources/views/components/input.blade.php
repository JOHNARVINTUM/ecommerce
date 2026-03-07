@props([
    'label' => null,
    'name',
    'type' => 'text',
    'value' => '',
])

<div>
    @if($label)
        <label for="{{ $name }}" class="mb-2 block text-sm font-medium text-slate-700">
            {{ $label }}
        </label>
    @endif

    <input
        id="{{ $name }}"
        name="{{ $name }}"
        type="{{ $type }}"
        value="{{ old($name, $value) }}"
        {{ $attributes->merge(['class' => 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-slate-500 focus:ring-2 focus:ring-slate-200']) }}
    >

    @error($name)
        <p class="mt-2 text-sm text-rose-600">{{ $message }}</p>
    @enderror
</div>
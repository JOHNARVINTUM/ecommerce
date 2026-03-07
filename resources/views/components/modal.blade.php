@props([
    'id' => 'modal',
    'title' => 'Modal Title',
])

<div
    x-data="{ open: false }"
    x-on:open-modal.window="if ($event.detail === '{{ $id }}') open = true"
    x-on:close-modal.window="if ($event.detail === '{{ $id }}') open = false"
    x-show="open"
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 p-4"
    style="display: none;"
>
    <div
        @click.away="open = false"
        class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-2xl"
    >
        <div class="flex items-start justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-900">{{ $title }}</h3>
            </div>

            <button
                type="button"
                @click="open = false"
                class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-700"
            >
                ✕
            </button>
        </div>

        <div class="mt-4">
            {{ $slot }}
        </div>
    </div>
</div>
@extends('layouts.provider')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/45">Provider Workspace</p>
            <h1 class="mt-2 text-3xl font-bold text-white">My Services</h1>
            <p class="mt-2 text-white/65">Manage the services you offer on LIMAX.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('provider.orders.index') }}"
               class="rounded-xl border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                Orders ({{ $newOrdersCount }} new)
            </a>
            <a href="{{ route('provider.services.create') }}"
               class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-[#111] transition hover:bg-white/90">
                Add Service
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-white/10 bg-white/[0.04] shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <table class="min-w-full divide-y divide-white/10">
            <thead class="bg-white/[0.03]">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/60">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/60">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/60">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-white/60">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-white/60">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                @forelse($services as $service)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-white">{{ $service->title }}</div>
                            <div class="text-sm text-white/45">{{ $service->slug }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-white/85">
                            {{ $service->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-white">
                            PHP {{ number_format($service->price, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($service->is_active)
                                <span class="rounded-full bg-emerald-400/15 px-3 py-1 text-xs font-semibold text-emerald-100">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white/80">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('provider.services.edit', $service) }}"
                                   class="rounded-lg border border-white/15 px-3 py-2 text-sm font-medium text-white/90 hover:bg-white/5">
                                    Edit
                                </a>

                                <form action="{{ route('provider.services.destroy', $service) }}" method="POST"
                                      onsubmit="return confirm('Delete this service?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg border border-rose-400/30 px-3 py-2 text-sm font-medium text-rose-100 hover:bg-rose-400/10">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-white/60">
                            No services yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $services->links() }}
    </div>
</div>
@endsection

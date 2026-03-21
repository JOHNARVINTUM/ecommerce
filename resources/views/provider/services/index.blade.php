@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">My Services</h1>
            <p class="mt-1 text-sm text-slate-600">Manage the services you offer on LIMAX.</p>
        </div>

        <div class="flex items-center gap-3">
            <a href="{{ route('provider.orders.index') }}"
               class="rounded-xl border border-amber-300 bg-amber-50 px-4 py-2 text-sm font-semibold text-amber-800 hover:bg-amber-100">
                Orders ({{ $newOrdersCount }} new)
            </a>
            <a href="{{ route('provider.services.create') }}"
               class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                Add Service
            </a>
        </div>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($services as $service)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="font-semibold text-slate-900">{{ $service->title }}</div>
                            <div class="text-sm text-slate-500">{{ $service->slug }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-700">
                            {{ $service->category->name ?? 'Uncategorized' }}
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-slate-900">
                            ₱{{ number_format($service->price, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($service->is_active)
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">
                                    Active
                                </span>
                            @else
                                <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                    Inactive
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('provider.services.edit', $service) }}"
                                   class="rounded-lg border border-slate-300 px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                    Edit
                                </a>

                                <form action="{{ route('provider.services.destroy', $service) }}" method="POST"
                                      onsubmit="return confirm('Delete this service?');">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="rounded-lg border border-rose-300 px-3 py-2 text-sm font-medium text-rose-700 hover:bg-rose-50">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                            No services yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>
@endsection

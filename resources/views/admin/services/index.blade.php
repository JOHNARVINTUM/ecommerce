@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="flex items-center justify-between gap-4">
            <h1 class="text-2xl font-bold text-white">Services</h1>
            <a href="{{ route('admin.services.create') }}" class="rounded-xl bg-white px-4 py-2 text-sm font-semibold text-[#111] transition hover:bg-white/90">
                Add Service
            </a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Provider</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Price</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($services as $service)
                        <tr>
                            <td class="px-4 py-3 text-sm text-white">{{ $service->title }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $service->provider->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $service->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">PHP {{ number_format($service->price, 2) }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $service->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-white/80">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.services.edit', $service) }}" class="font-semibold text-sky-300 hover:text-sky-200">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.services.toggle', $service) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="font-semibold text-indigo-300 hover:text-indigo-200">
                                            {{ $service->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.services.destroy', $service) }}" onsubmit="return confirm('Delete this service?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-rose-300 hover:text-rose-200">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $services->links() }}
        </div>
    </div>
@endsection

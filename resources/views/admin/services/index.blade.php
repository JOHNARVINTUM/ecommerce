@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Services</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Provider</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Price</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($services as $service)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $service->title }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $service->provider->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $service->category->name ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">PHP {{ number_format($service->price, 2) }}</td>
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
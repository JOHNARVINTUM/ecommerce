@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Categories</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Slug</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $category->slug }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $category->is_active ? 'Active' : 'Inactive' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>
@endsection
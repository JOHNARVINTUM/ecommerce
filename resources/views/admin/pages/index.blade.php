@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-bold text-slate-900">Pages</h1>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-slate-500">URL</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @foreach ($pages as $page)
                        <tr>
                            <td class="px-4 py-3 text-sm text-slate-800">{{ $page['title'] }}</td>
                            <td class="px-4 py-3 text-sm text-slate-600">{{ $page['slug'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@extends('layouts.admin')

@section('content')
    <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-white">Categories</h1>
            <a href="{{ route('admin.categories.create') }}" class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Add Category
            </a>
        </div>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full divide-y divide-white/10">
                <thead class="bg-white/5">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Slug</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase text-white/60">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-4 py-3 text-sm text-white">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-sm text-white/70">{{ $category->slug }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $category->is_active ? 'bg-emerald-500/20 text-emerald-300' : 'bg-rose-500/20 text-rose-300' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-white/80">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="font-semibold text-indigo-300 hover:text-indigo-200">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Delete this category?');">
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
            {{ $categories->links() }}
        </div>
    </div>
@endsection
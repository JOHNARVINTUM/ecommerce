@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-3xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Create Category</h1>
                <p class="mt-1 text-sm text-white/65">Add a new service category for the marketplace.</p>
            </div>
            <a href="{{ route('admin.categories.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                Back
            </a>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium text-white/85">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">
                @error('name') <p class="mt-2 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="mb-2 block text-sm font-medium text-white/85">Slug (optional)</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">
                @error('slug') <p class="mt-2 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="headline" class="mb-2 block text-sm font-medium text-white/85">Headline</label>
                <input type="text" id="headline" name="headline" value="{{ old('headline') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">
                @error('headline') <p class="mt-2 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-white/85">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white placeholder:text-white/45 focus:border-white/35 focus:ring-white/20">{{ old('description') }}</textarea>
                @error('description') <p class="mt-2 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="sort_order" class="mb-2 block text-sm font-medium text-white/85">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-sm text-white focus:border-white/35 focus:ring-white/20">
                    @error('sort_order') <p class="mt-2 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>

                <div class="flex items-center gap-3 pt-8">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', true)) class="rounded border-white/30 bg-transparent text-indigo-400 focus:ring-indigo-300/50">
                    <label for="is_active" class="text-sm font-medium text-white/85">Active Category</label>
                </div>
            </div>

            <button type="submit" class="rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700">
                Create Category
            </button>
        </form>
    </div>
@endsection

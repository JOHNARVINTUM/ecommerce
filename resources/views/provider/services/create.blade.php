@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-slate-900">Create Service</h1>
        <p class="mt-1 text-sm text-slate-600">Add a new service listing for customers to browse.</p>
    </div>

    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <form action="{{ route('provider.services.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="service_category_id" class="mb-2 block text-sm font-medium text-slate-700">Category</label>
                <select name="service_category_id" id="service_category_id" class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    <option value="">Select category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('service_category_id') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('service_category_id') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="title" class="mb-2 block text-sm font-medium text-slate-700">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3">
                @error('title') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="short_description" class="mb-2 block text-sm font-medium text-slate-700">Short Description</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}"
                       class="w-full rounded-xl border border-slate-300 px-4 py-3">
                @error('short_description') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-slate-700">Description</label>
                <textarea name="description" id="description" rows="6"
                          class="w-full rounded-xl border border-slate-300 px-4 py-3">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-slate-700">Price</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('price') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="currency" class="mb-2 block text-sm font-medium text-slate-700">Currency</label>
                    <input type="text" name="currency" id="currency" value="{{ old('currency', 'PHP') }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('currency') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="delivery_time_days" class="mb-2 block text-sm font-medium text-slate-700">Delivery Time (days)</label>
                    <input type="number" name="delivery_time_days" id="delivery_time_days" value="{{ old('delivery_time_days') }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('delivery_time_days') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="revisions" class="mb-2 block text-sm font-medium text-slate-700">Revisions</label>
                    <input type="number" name="revisions" id="revisions" value="{{ old('revisions') }}"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3">
                    @error('revisions') <p class="mt-1 text-sm text-rose-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))>
                <label for="is_active" class="text-sm font-medium text-slate-700">Set service as active</label>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                        class="rounded-xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                    Save Service
                </button>

                <a href="{{ route('provider.services.index') }}"
                   class="rounded-xl border border-slate-300 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection
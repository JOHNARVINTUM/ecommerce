@extends('layouts.admin')

@section('content')
    <div class="mx-auto max-w-4xl rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">Create Service</h1>
                <p class="mt-1 text-sm text-white/65">Add a service directly from the admin workspace.</p>
            </div>
            <a href="{{ route('admin.services.index') }}" class="rounded-lg border border-white/20 bg-white/5 px-4 py-2 text-sm font-semibold text-white/90 transition hover:border-white/35 hover:bg-white/10">
                Back
            </a>
        </div>

        <form action="{{ route('admin.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="provider_user_id" class="mb-2 block text-sm font-medium text-white/85">Provider</label>
                    <select name="provider_user_id" id="provider_user_id" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                        @foreach ($providers as $provider)
                            <option value="{{ $provider->id }}" @selected(old('provider_user_id') == $provider->id)>{{ $provider->name }}</option>
                        @endforeach
                    </select>
                    @error('provider_user_id') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="service_category_id" class="mb-2 block text-sm font-medium text-white/85">Category</label>
                    <select name="service_category_id" id="service_category_id" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('service_category_id') == $category->id)>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('service_category_id') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="title" class="mb-2 block text-sm font-medium text-white/85">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('title') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="short_description" class="mb-2 block text-sm font-medium text-white/85">Short Description</label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('short_description') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium text-white/85">Description</label>
                <textarea name="description" id="description" rows="5" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-6 md:grid-cols-4">
                <div>
                    <label for="price" class="mb-2 block text-sm font-medium text-white/85">Price</label>
                    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('price') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="currency" class="mb-2 block text-sm font-medium text-white/85">Currency</label>
                    <input type="text" name="currency" id="currency" value="{{ old('currency', 'PHP') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('currency') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="delivery_time_days" class="mb-2 block text-sm font-medium text-white/85">Delivery Days</label>
                    <input type="number" min="1" name="delivery_time_days" id="delivery_time_days" value="{{ old('delivery_time_days') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('delivery_time_days') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="revisions" class="mb-2 block text-sm font-medium text-white/85">Revisions</label>
                    <input type="number" min="0" name="revisions" id="revisions" value="{{ old('revisions') }}" class="w-full rounded-xl border border-white/20 bg-white/5 px-4 py-3 text-white">
                    @error('revisions') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="thumbnail" class="mb-2 block text-sm font-medium text-white/85">Thumbnail</label>
                    <input type="file" name="thumbnail" id="thumbnail" accept=".jpg,.jpeg,.png,.webp" class="block w-full text-sm text-white/80 file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:font-semibold file:text-[#111] hover:file:bg-white/90">
                    @error('thumbnail') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="gallery_images" class="mb-2 block text-sm font-medium text-white/85">Gallery Images</label>
                    <input type="file" name="gallery_images[]" id="gallery_images" multiple accept=".jpg,.jpeg,.png,.webp" class="block w-full text-sm text-white/80 file:mr-4 file:rounded-lg file:border-0 file:bg-white file:px-4 file:py-2 file:font-semibold file:text-[#111] hover:file:bg-white/90">
                    @error('gallery_images') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                    @error('gallery_images.*') <p class="mt-1 text-sm text-rose-300">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex items-center gap-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true)) class="rounded border-white/30 bg-transparent text-indigo-400 focus:ring-indigo-300/50">
                <label for="is_active" class="text-sm font-medium text-white/85">Active Service</label>
            </div>

            <button type="submit" class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#111] transition hover:bg-white/90">
                Create Service
            </button>
        </form>
    </div>
@endsection

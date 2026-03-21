@extends('layouts.provider')

@section('content')
    <div class="space-y-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.26em] text-white/45">Provider Workspace</p>
            <h1 class="mt-2 text-3xl font-bold text-white">Create Service</h1>
            <p class="mt-2 text-white/65">Add a new service listing for customers to browse.</p>
        </div>

        <div class="rounded-2xl border border-white/10 bg-white/[0.04] p-6 shadow-[0_20px_40px_rgba(0,0,0,0.25)]">
            <form action="{{ route('provider.services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="service_category_id" class="mb-2 block text-sm font-medium text-white/90">Category</label>
                    <select name="service_category_id" id="service_category_id" class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" @selected(old('service_category_id') == $category->id)>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('service_category_id') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="title" class="mb-2 block text-sm font-medium text-white/90">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                           class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white placeholder:text-white/40">
                    @error('title') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="short_description" class="mb-2 block text-sm font-medium text-white/90">Short Description</label>
                    <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}"
                           class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white placeholder:text-white/40">
                    @error('short_description') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="mb-2 block text-sm font-medium text-white/90">Description</label>
                    <textarea name="description" id="description" rows="6"
                              class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white placeholder:text-white/40">{{ old('description') }}</textarea>
                    @error('description') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="price" class="mb-2 block text-sm font-medium text-white/90">Price</label>
                        <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}"
                               class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        @error('price') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="currency" class="mb-2 block text-sm font-medium text-white/90">Currency</label>
                        <input type="text" name="currency" id="currency" value="{{ old('currency', 'PHP') }}"
                               class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        @error('currency') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="delivery_time_days" class="mb-2 block text-sm font-medium text-white/90">Delivery Time (days)</label>
                        <input type="number" name="delivery_time_days" id="delivery_time_days" value="{{ old('delivery_time_days') }}"
                               class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        @error('delivery_time_days') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="revisions" class="mb-2 block text-sm font-medium text-white/90">Revisions</label>
                        <input type="number" name="revisions" id="revisions" value="{{ old('revisions') }}"
                               class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        @error('revisions') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <div>
                        <label for="thumbnail" class="mb-2 block text-sm font-medium text-white/90">Thumbnail Image</label>
                        <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                               class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        <p class="mt-1 text-xs text-white/55">Required. JPG, PNG, or WEBP up to 2MB.</p>
                        @error('thumbnail') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="gallery_images" class="mb-2 block text-sm font-medium text-white/90">Gallery Images</label>
                        <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
                               class="w-full rounded-xl border border-white/15 bg-[#0d0e13] px-4 py-3 text-white">
                        <p class="mt-1 text-xs text-white/55">Optional. Up to 8 images, 4MB each.</p>
                        @error('gallery_images') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                        @error('gallery_images.*') <p class="mt-1 text-sm text-rose-200">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 rounded-xl border border-white/10 bg-white/[0.03] px-4 py-3">
                    <input type="checkbox" name="is_active" id="is_active" value="1" @checked(old('is_active', true))>
                    <label for="is_active" class="text-sm font-medium text-white/90">Set service as active</label>
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="rounded-xl bg-white px-5 py-3 text-sm font-semibold text-[#111] hover:bg-white/90">
                        Save Service
                    </button>

                    <a href="{{ route('provider.services.index') }}"
                       class="rounded-xl border border-white/20 bg-white/5 px-5 py-3 text-sm font-semibold text-white/90 hover:border-white/35 hover:bg-white/10">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

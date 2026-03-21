<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ServiceCategory;
use App\Models\ServiceListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProviderServiceController extends Controller
{
    public function index()
    {
        $services = ServiceListing::with('category')
            ->where('provider_user_id', auth()->id())
            ->latest()
            ->paginate(10);

        $newOrdersCount = Order::where('provider_user_id', auth()->id())
            ->whereIn('status', [Order::STATUS_PENDING, Order::STATUS_CONFIRMED])
            ->count();

        return view('provider.services.index', compact('services', 'newOrdersCount'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('provider.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $hasThumbnailPath = Schema::hasColumn('service_listings', 'thumbnail_path');
        $hasGalleryImages = Schema::hasColumn('service_listings', 'gallery_images');

        $validated = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'delivery_time_days' => ['nullable', 'integer', 'min:1'],
            'revisions' => ['nullable', 'integer', 'min:0'],
            'thumbnail' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['provider_user_id'] = auth()->id();
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

        if ($hasThumbnailPath && $request->hasFile('thumbnail')) {
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('services/thumbnails', 'public');
        } else {
            unset($validated['thumbnail_path']);
        }

        if ($hasGalleryImages) {
            $validated['gallery_images'] = collect($request->file('gallery_images', []))
                ->map(fn ($file) => $file->store('services/galleries', 'public'))
                ->values()
                ->all();
        } else {
            unset($validated['gallery_images']);
        }

        ServiceListing::create($validated);

        return redirect()
            ->route('provider.services.index')
            ->with('success', 'Service created successfully.');
    }

    public function edit(ServiceListing $service)
    {
        abort_unless($service->provider_user_id === auth()->id(), 403);

        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('provider.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, ServiceListing $service)
    {
        abort_unless($service->provider_user_id === auth()->id(), 403);

        $hasThumbnailPath = Schema::hasColumn('service_listings', 'thumbnail_path');
        $hasGalleryImages = Schema::hasColumn('service_listings', 'gallery_images');

        $validated = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'delivery_time_days' => ['nullable', 'integer', 'min:1'],
            'revisions' => ['nullable', 'integer', 'min:0'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'keep_existing_gallery' => ['nullable', 'array'],
            'keep_existing_gallery.*' => ['string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $service->title !== $validated['title']
            ? $this->generateUniqueSlug($validated['title'], $service->id)
            : $service->slug;

        $validated['is_active'] = $request->boolean('is_active');

        if ($hasThumbnailPath && $request->hasFile('thumbnail')) {
            if ($service->thumbnail_path) {
                Storage::disk('public')->delete($service->thumbnail_path);
            }
            $validated['thumbnail_path'] = $request->file('thumbnail')->store('services/thumbnails', 'public');
        }

        if ($hasGalleryImages) {
            $existingGallery = collect($service->gallery_images ?? []);
            $keptGallery = collect($request->input('keep_existing_gallery', []))
                ->intersect($existingGallery)
                ->values();

            $removedGallery = $existingGallery->diff($keptGallery)->values();
            foreach ($removedGallery as $removedPath) {
                Storage::disk('public')->delete($removedPath);
            }

            $newGallery = collect($request->file('gallery_images', []))
                ->map(fn ($file) => $file->store('services/galleries', 'public'))
                ->values();

            $validated['gallery_images'] = $keptGallery
                ->concat($newGallery)
                ->take(8)
                ->values()
                ->all();
        } else {
            unset($validated['gallery_images']);
        }

        $service->update($validated);

        return redirect()
            ->route('provider.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(ServiceListing $service)
    {
        abort_unless($service->provider_user_id === auth()->id(), 403);

        $hasThumbnailPath = Schema::hasColumn('service_listings', 'thumbnail_path');
        $hasGalleryImages = Schema::hasColumn('service_listings', 'gallery_images');

        if ($hasThumbnailPath && $service->thumbnail_path) {
            Storage::disk('public')->delete($service->thumbnail_path);
        }

        if ($hasGalleryImages) {
            foreach (($service->gallery_images ?? []) as $galleryPath) {
                Storage::disk('public')->delete($galleryPath);
            }
        }

        $service->delete();

        return redirect()
            ->route('provider.services.index')
            ->with('success', 'Service deleted successfully.');
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 2;

        while (
            ServiceListing::where('slug', $slug)
                ->when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}

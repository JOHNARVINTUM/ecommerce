<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceListing;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminServiceController extends Controller
{
    public function index()
    {
        $services = ServiceListing::with(['provider', 'category'])->latest()->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();
        $providers = User::where('role', User::ROLE_PROVIDER)->orderBy('name')->get();

        return view('admin.services.create', compact('categories', 'providers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateService($request);

        ServiceListing::create($this->prepareServiceData($request, $validated));

        return redirect()->route('admin.services.index')->with('success', 'Service created successfully.');
    }

    public function edit(ServiceListing $service)
    {
        $categories = ServiceCategory::where('is_active', true)->orderBy('sort_order')->get();
        $providers = User::where('role', User::ROLE_PROVIDER)->orderBy('name')->get();

        return view('admin.services.edit', compact('service', 'categories', 'providers'));
    }

    public function update(Request $request, ServiceListing $service): RedirectResponse
    {
        $validated = $this->validateService($request, $service);

        $service->update($this->prepareServiceData($request, $validated, $service));

        return redirect()->route('admin.services.index')->with('success', 'Service updated successfully.');
    }

    public function toggle(ServiceListing $service): RedirectResponse
    {
        $service->update([
            'is_active' => ! $service->is_active,
        ]);

        $state = $service->is_active ? 'activated' : 'deactivated';

        return redirect()->route('admin.services.index')->with('success', "Service {$state} successfully.");
    }

    public function destroy(ServiceListing $service): RedirectResponse
    {
        if ($service->orders()->exists()) {
            return redirect()->route('admin.services.index')->with('error', 'Cannot delete a service with existing orders.');
        }

        if (Schema::hasColumn('service_listings', 'thumbnail_path') && $service->thumbnail_path) {
            Storage::disk('public')->delete($service->thumbnail_path);
        }

        if (Schema::hasColumn('service_listings', 'gallery_images')) {
            foreach (($service->gallery_images ?? []) as $galleryPath) {
                Storage::disk('public')->delete($galleryPath);
            }
        }

        $service->delete();

        return redirect()->route('admin.services.index')->with('success', 'Service deleted successfully.');
    }

    protected function validateService(Request $request, ?ServiceListing $service = null): array
    {
        return $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'provider_user_id' => ['required', Rule::exists('users', 'id')->where('role', User::ROLE_PROVIDER)],
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'delivery_time_days' => ['nullable', 'integer', 'min:1'],
            'revisions' => ['nullable', 'integer', 'min:0'],
            'thumbnail' => [$service ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'gallery_images' => ['nullable', 'array', 'max:8'],
            'gallery_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'keep_existing_gallery' => ['nullable', 'array'],
            'keep_existing_gallery.*' => ['string'],
            'is_active' => ['nullable', 'boolean'],
        ]);
    }

    protected function prepareServiceData(Request $request, array $validated, ?ServiceListing $service = null): array
    {
        $hasThumbnailPath = Schema::hasColumn('service_listings', 'thumbnail_path');
        $hasGalleryImages = Schema::hasColumn('service_listings', 'gallery_images');

        $validated['slug'] = $service && $service->title === $validated['title']
            ? $service->slug
            : $this->generateUniqueSlug($validated['title'], $service?->id);
        $validated['is_active'] = $request->boolean('is_active');

        if ($hasThumbnailPath && $request->hasFile('thumbnail')) {
            if ($service?->thumbnail_path) {
                Storage::disk('public')->delete($service->thumbnail_path);
            }

            $validated['thumbnail_path'] = $request->file('thumbnail')->store('services/thumbnails', 'public');
        }

        if ($hasGalleryImages) {
            $existingGallery = collect($service?->gallery_images ?? []);
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
        }

        return $validated;
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
            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}

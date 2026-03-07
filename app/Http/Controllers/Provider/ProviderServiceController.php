<?php

namespace App\Http\Controllers\Provider;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\ServiceListing;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProviderServiceController extends Controller
{
    public function index()
    {
        $services = ServiceListing::with('category')
            ->where('provider_user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('provider.services.index', compact('services'));
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
        $validated = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'delivery_time_days' => ['nullable', 'integer', 'min:1'],
            'revisions' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['provider_user_id'] = auth()->id();
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');

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

        $validated = $request->validate([
            'service_category_id' => ['required', 'exists:service_categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'delivery_time_days' => ['nullable', 'integer', 'min:1'],
            'revisions' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = $service->title !== $validated['title']
            ? $this->generateUniqueSlug($validated['title'], $service->id)
            : $service->slug;

        $validated['is_active'] = $request->boolean('is_active');

        $service->update($validated);

        return redirect()
            ->route('provider.services.index')
            ->with('success', 'Service updated successfully.');
    }

    public function destroy(ServiceListing $service)
    {
        abort_unless($service->provider_user_id === auth()->id(), 403);

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
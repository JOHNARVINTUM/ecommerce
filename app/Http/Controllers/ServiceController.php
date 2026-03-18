<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceListing;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.services.index', compact('categories'));
    }

    public function category(ServiceCategory $category)
    {
        abort_unless($category->is_active, 404);

        $services = ServiceListing::with(['category', 'provider'])
            ->where('is_active', true)
            ->where('service_category_id', $category->id)
            ->latest()
            ->paginate(12);

        return view('pages.services.category', compact('category', 'services'));
    }

    public function show(ServiceListing $service)
    {
        $service->load(['category', 'provider']);

        abort_unless($service->is_active, 404);

        return view('pages.services.show', compact('service'));
    }
}

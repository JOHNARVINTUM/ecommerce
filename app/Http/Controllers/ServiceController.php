<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceListing;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = ServiceListing::with(['category', 'provider'])
            ->where('is_active', true);

        if ($request->filled('category')) {
            $query->where('service_category_id', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('short_description', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $services = $query->latest()->paginate(12)->withQueryString();

        $categories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('pages.services.index', compact('services', 'categories'));
    }

    public function show(ServiceListing $service)
    {
        $service->load(['category', 'provider']);

        abort_unless($service->is_active, 404);

        return view('pages.services.show', compact('service'));
    }
}
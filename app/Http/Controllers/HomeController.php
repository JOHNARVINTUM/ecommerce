<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use App\Models\ServiceListing;

class HomeController extends Controller
{
    public function index()
    {
        $featuredCategories = ServiceCategory::where('is_active', true)
            ->orderBy('sort_order')
            ->take(6)
            ->get();

        $featuredServices = ServiceListing::with(['category', 'provider'])
            ->where('is_active', true)
            ->latest()
            ->take(8)
            ->get();

        return view('pages.home', compact('featuredCategories', 'featuredServices'));
    }
}
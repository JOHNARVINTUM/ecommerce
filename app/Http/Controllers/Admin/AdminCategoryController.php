<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('sort_order')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }
}
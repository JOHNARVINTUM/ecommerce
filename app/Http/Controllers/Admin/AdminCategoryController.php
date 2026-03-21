<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminCategoryController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::orderBy('sort_order')->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:service_categories,slug'],
            'headline' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['name']);

        ServiceCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'headline' => $validated['headline'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(ServiceCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ServiceCategory $category)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('service_categories', 'slug')->ignore($category->id)],
            'headline' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['name']);

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'headline' => $validated['headline'],
            'description' => $validated['description'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ServiceCategory $category)
    {
        if ($category->listings()->exists()) {
            return redirect()->route('admin.categories.index')->with('error', 'Cannot delete a category with existing services.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully.');
    }
}
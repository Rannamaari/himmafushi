<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\BusinessCategory;
use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index(Request $request, string $category)
    {
        $categoryModel = BusinessCategory::query()->where('slug', $category)->where('active', true)->first()
            ?? new BusinessCategory(['name' => str($category)->replace('-', ' ')->title(), 'slug' => $category]);
        $search = trim((string) $request->string('q'));
        $businesses = Business::public()->where('business_category_id', $categoryModel->id ?? 0)->with('category')->when($search !== '', fn ($query) => $query->where(fn ($nested) => $nested->where('name', 'like', "%{$search}%")->orWhere('short_description', 'like', "%{$search}%")))->orderByDesc('featured')->orderBy('name')->paginate(12)->withQueryString();

        return view('directory.index', compact('businesses', 'categoryModel', 'search'));
    }

    public function show(Business $business, string $category)
    {
        abort_unless($business->active && $business->category?->slug === $category, 404);
        $business->load(['category', 'services' => fn ($query) => $query->where('available', true)->orderBy('sort_order'), 'menuCategories' => fn ($query) => $query->where('active', true)->with(['items' => fn ($items) => $items->where('available', true)->orderBy('sort_order')])->orderBy('sort_order')]);

        return view('directory.show', compact('business'));
    }
}

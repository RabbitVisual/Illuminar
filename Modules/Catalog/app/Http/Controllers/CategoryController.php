<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::with('parent')
            ->orderBy('name')
            ->paginate(15);

        return view('catalog::categories.index', compact('categories'));
    }

    public function create(): View
    {
        $parentCategories = Category::whereNull('parent_id')->orderBy('name')->get();

        return view('catalog::categories.create', compact('parentCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ]);

        $slug = Str::slug($validated['name']);
        $slug = Category::where('slug', $slug)->exists() ? $slug . '-' . uniqid() : $slug;

        Category::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'parent_id' => $validated['parent_id'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('catalog.categories.index')->with('success', 'Categoria criada com sucesso.');
    }

    public function show(Category $category): RedirectResponse
    {
        return redirect()->route('catalog.categories.edit', $category);
    }

    public function edit(Category $category): View
    {
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('name')
            ->get();

        return view('catalog::categories.edit', compact('category', 'parentCategories'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
        ]);

        $parentId = $validated['parent_id'] ?? null;
        if ($parentId == $category->id) {
            $parentId = null;
        }

        $slug = Str::slug($validated['name']);
        if (Category::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
            $slug = $slug . '-' . $category->id;
        }

        $category->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'parent_id' => $parentId,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('catalog.categories.index')->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()->route('catalog.categories.index')->with('success', 'Categoria excluída com sucesso.');
    }
}

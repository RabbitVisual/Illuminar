<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index(): View
    {
        $brands = Brand::orderBy('name')->paginate(15);

        return view('catalog::brands.index', compact('brands'));
    }

    public function create(): View
    {
        return view('catalog::brands.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $slug = Str::slug($validated['name']);
        $slug = Brand::where('slug', $slug)->exists() ? $slug . '-' . uniqid() : $slug;

        Brand::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'logo' => $validated['logo'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('catalog.brands.index')->with('success', 'Marca criada com sucesso.');
    }

    public function show(Brand $brand): RedirectResponse
    {
        return redirect()->route('catalog.brands.edit', $brand);
    }

    public function edit(Brand $brand): View
    {
        return view('catalog::brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $slug = Str::slug($validated['name']);
        if (Brand::where('slug', $slug)->where('id', '!=', $brand->id)->exists()) {
            $slug = $slug . '-' . $brand->id;
        }

        $brand->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'logo' => $validated['logo'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('catalog.brands.index')->with('success', 'Marca atualizada com sucesso.');
    }

    public function destroy(Brand $brand): RedirectResponse
    {
        $brand->delete();

        return redirect()->route('catalog.brands.index')->with('success', 'Marca excluída com sucesso.');
    }
}

<?php

namespace Modules\Catalog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Brand;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;
use Modules\Core\Helpers\UtilsHelper;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::with(['brand', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        if ($request->filled('color_temperature_k')) {
            $query->where('color_temperature_k', $request->color_temperature_k);
        }

        $products = $query->orderBy('name')->paginate(15)->withQueryString();

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();
        $colorTemperatures = Product::whereNotNull('color_temperature_k')
            ->distinct()
            ->orderBy('color_temperature_k')
            ->pluck('color_temperature_k');

        return view('catalog::products.index', compact('products', 'categories', 'brands', 'colorTemperatures'));
    }

    public function create(): View
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('catalog::products.create', compact('categories', 'brands'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku'],
            'barcode' => ['nullable', 'string', 'max:100', 'unique:products,barcode'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'string'],
            'cost_price' => ['nullable', 'string'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
            'voltage' => ['nullable', 'string', 'max:20'],
            'power_watts' => ['nullable', 'numeric', 'min:0'],
            'color_temperature_k' => ['nullable', 'integer', 'min:0'],
            'lumens' => ['nullable', 'integer', 'min:0'],
        ]);

        $price = (int) round((float) UtilsHelper::formatMoneyToDatabase($validated['price']) * 100);
        $costPrice = ! empty($validated['cost_price'])
            ? (int) round((float) UtilsHelper::formatMoneyToDatabase($validated['cost_price']) * 100)
            : 0;

        $slug = Str::slug($validated['name']);
        $slug = Product::where('slug', $slug)->exists() ? $slug . '-' . Str::slug($validated['sku']) : $slug;

        Product::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'],
            'barcode' => UtilsHelper::onlyDigits($validated['barcode'] ?? '') ?: null,
            'description' => $validated['description'] ?? null,
            'price' => $price,
            'cost_price' => $costPrice,
            'brand_id' => $validated['brand_id'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'voltage' => $validated['voltage'] ?? null,
            'power_watts' => $validated['power_watts'] ?? null,
            'color_temperature_k' => $validated['color_temperature_k'] ?? null,
            'lumens' => $validated['lumens'] ?? null,
        ]);

        return redirect()->route('catalog.products.index')->with('success', 'Produto criado com sucesso.');
    }

    public function show(Product $product): RedirectResponse
    {
        return redirect()->route('catalog.products.edit', $product);
    }

    public function edit(Product $product): View
    {
        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('catalog::products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['required', 'string', 'max:100', 'unique:products,sku,' . $product->id],
            'barcode' => ['nullable', 'string', 'max:100', 'unique:products,barcode,' . $product->id],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'string'],
            'cost_price' => ['nullable', 'string'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'is_active' => ['boolean'],
            'voltage' => ['nullable', 'string', 'max:20'],
            'power_watts' => ['nullable', 'numeric', 'min:0'],
            'color_temperature_k' => ['nullable', 'integer', 'min:0'],
            'lumens' => ['nullable', 'integer', 'min:0'],
        ]);

        $price = (int) round((float) UtilsHelper::formatMoneyToDatabase($validated['price']) * 100);
        $costPrice = ! empty($validated['cost_price'])
            ? (int) round((float) UtilsHelper::formatMoneyToDatabase($validated['cost_price']) * 100)
            : 0;

        $slug = Str::slug($validated['name']);
        if (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug = $slug . '-' . $product->id;
        }

        $product->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'sku' => $validated['sku'],
            'barcode' => UtilsHelper::onlyDigits($validated['barcode'] ?? '') ?: null,
            'description' => $validated['description'] ?? null,
            'price' => $price,
            'cost_price' => $costPrice,
            'brand_id' => $validated['brand_id'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
            'is_active' => $request->boolean('is_active', true),
            'voltage' => $validated['voltage'] ?? null,
            'power_watts' => $validated['power_watts'] ?? null,
            'color_temperature_k' => $validated['color_temperature_k'] ?? null,
            'lumens' => $validated['lumens'] ?? null,
        ]);

        return redirect()->route('catalog.products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()->route('catalog.products.index')->with('success', 'Produto excluído com sucesso.');
    }
}

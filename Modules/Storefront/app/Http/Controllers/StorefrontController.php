<?php

namespace Modules\Storefront\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;
use Modules\Sales\Models\Order;
use Modules\Sales\Services\OrderService;

class StorefrontController extends Controller
{
    public function index(Request $request): View
    {
        $productsQuery = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with(['brand', 'category']);

        if ($request->filled('category')) {
            $productsQuery->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $products = $productsQuery
            ->latest()
            ->take(12)
            ->get();

        $categories = Category::query()
            ->where('is_active', true)
            ->whereHas('products', fn ($q) => $q->where('is_active', true))
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('storefront::index', compact('products', 'categories'));
    }

    public function catalog(Request $request): View
    {
        $productsQuery = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with(['brand', 'category']);

        if ($request->filled('category')) {
            $productsQuery->whereHas('category', fn ($q) => $q->where('slug', $request->category));
        }

        $sort = $request->get('sort', 'latest');

        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $productsQuery->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $productsQuery->orderBy('name', 'desc');
                break;
            case 'latest':
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery
            ->paginate(24)
            ->withQueryString();

        $categories = Category::query()
            ->where('is_active', true)
            ->whereHas('products', fn ($q) => $q->where('is_active', true))
            ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->get();

        $currentCategory = $request->get('category');

        return view('storefront::catalog', compact('products', 'categories', 'sort', 'currentCategory'));
    }

    public function product(string $slug): View
    {
        $product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->with(['brand', 'category'])
            ->firstOrFail();

        return view('storefront::product', compact('product'));
    }

    public function cart(): View
    {
        return view('storefront::cart');
    }

    public function checkout(): View
    {
        return view('storefront::checkout');
    }

    public function processCheckout(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'in:pix,credit_card,debit_card,cash,boleto'],
        ]);

        try {
            $orderService = new OrderService;
            $order = $orderService->createOrder([
                'user_id' => null,
                'customer_id' => auth()->id(),
                'payment_method' => $validated['payment_method'],
                'origin' => Order::ORIGIN_STOREFRONT,
                'status' => Order::STATUS_PENDING,
            ], $validated['items']);

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
                'message' => 'Pedido realizado com sucesso!',
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar o pedido. Tente novamente.',
            ], 500);
        }
    }
}

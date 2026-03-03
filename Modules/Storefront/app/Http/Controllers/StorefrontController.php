<?php

namespace Modules\Storefront\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Product;
use Modules\Sales\Models\Order;
use Modules\Sales\Services\OrderService;

class StorefrontController extends Controller
{
    public function index(): View
    {
        $products = Product::query()
            ->where('is_active', true)
            ->where('stock', '>', 0)
            ->with(['brand', 'category'])
            ->latest()
            ->take(8)
            ->get();

        return view('storefront::index', compact('products'));
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

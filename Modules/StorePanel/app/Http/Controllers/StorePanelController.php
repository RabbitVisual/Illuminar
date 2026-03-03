<?php

namespace Modules\StorePanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Product;
use Modules\Sales\Models\Order;
use Modules\Sales\Services\OrderService;

class StorePanelController extends Controller
{
    public function index(): View
    {
        return view('storepanel::pos.index');
    }

    public function searchProduct(Request $request): JsonResponse
    {
        $request->validate(['term' => ['required', 'string', 'max:255']]);

        $term = trim($request->term);
        $product = Product::where('barcode', $term)
            ->orWhere('sku', $term)
            ->where('is_active', true)
            ->first();

        if (! $product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
        }

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'barcode' => $product->barcode,
            'price' => $product->price,
            'price_formatted' => $product->price_formatted,
            'stock' => $product->stock ?? 0,
            'voltage' => $product->voltage,
            'power_watts' => $product->power_watts,
            'lumens' => $product->lumens,
            'color_temperature_k' => $product->color_temperature_k,
        ]);
    }

    public function checkout(Request $request): JsonResponse
    {
        $rules = [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:pix,credit_card,debit_card,cash'],
        ];

        if ($request->payment_method === 'cash') {
            $rules['amount_received'] = ['nullable', 'string'];
        }

        $validated = $request->validate($rules);

        $items = array_map(
            fn ($item) => ['product_id' => (int) $item['product_id'], 'quantity' => (int) $item['quantity']],
            $validated['items']
        );

        try {
            $orderService = app(OrderService::class);
            $order = $orderService->createOrder([
                'user_id' => auth()->id(),
                'customer_id' => null,
                'origin' => Order::ORIGIN_POS,
                'payment_method' => $validated['payment_method'],
                'status' => Order::STATUS_PAID,
            ], $items);

            return response()->json([
                'success' => true,
                'order_number' => $order->order_number,
            ]);
        } catch (\InvalidArgumentException $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 422);
        }
    }
}

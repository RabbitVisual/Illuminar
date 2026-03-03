<?php

namespace Modules\Storefront\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Category;
use Modules\Catalog\Models\Product;
use Modules\Payment\Models\Payment;
use Modules\Payment\Services\GatewayResolver;
use Modules\Payment\Services\PaymentService;
use Modules\Payment\Models\PaymentGateway;
use Modules\Sales\Models\Order;
use Modules\Sales\Services\OrderService;
use Modules\Shipping\Services\ShippingCalculatorService;

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

    public function checkoutSuccess(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderNumber = $request->query('order');

        if ($orderNumber && auth()->check()) {
            $order = Order::where('order_number', $orderNumber)
                ->where('customer_id', auth()->id())
                ->first();

            if ($order) {
                return redirect()
                    ->route('customer.orders.show', $order->order_number)
                    ->with('success', 'Pedido registrado. Assim que o pagamento for confirmado você verá o status atualizado aqui.');
            }
        }

        return redirect()
            ->route('customer.orders.index')
            ->with('success', 'Pedido registrado. Assim que o pagamento for confirmado você verá o status atualizado em Meus Pedidos.');
    }

    public function checkoutCancel(Request $request): \Illuminate\Http\RedirectResponse
    {
        $orderNumber = $request->query('order');

        if ($orderNumber && auth()->check()) {
            $order = Order::where('order_number', $orderNumber)
                ->where('customer_id', auth()->id())
                ->first();

            if ($order) {
                return redirect()
                    ->route('customer.orders.show', $order->order_number)
                    ->with('success', 'Pagamento não foi concluído. Você pode tentar novamente a partir deste pedido.');
            }
        }

        return redirect()
            ->route('storefront.cart')
            ->with('success', 'Pagamento cancelado. Você pode tentar novamente a partir do carrinho.');
    }

    public function calculateShipping(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'zip_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'size:2'],
            'cart_total' => ['required', 'integer', 'min:0'],
        ]);

        $calculator = new ShippingCalculatorService;
        $rates = $calculator->calculateRates(
            $validated['zip_code'],
            $validated['city'],
            $validated['state'],
            (int) $validated['cart_total']
        );

        return response()->json([
            'success' => true,
            'rates' => $rates,
            'message' => empty($rates)
                ? 'Infelizmente não entregamos nesta região no momento.'
                : null,
        ]);
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
            'shipping_method_id' => ['nullable', 'integer', 'exists:shipping_methods,id'],
            'shipping_amount' => ['nullable', 'integer', 'min:0'],
        ]);

        try {
            $orderService = new OrderService;
            $order = $orderService->createOrder([
                'user_id' => null,
                'customer_id' => auth()->id(),
                'payment_method' => $validated['payment_method'],
                'origin' => Order::ORIGIN_STOREFRONT,
                'status' => Order::STATUS_PENDING,
                'shipping_method_id' => $validated['shipping_method_id'] ?? null,
                'shipping_amount' => $validated['shipping_amount'] ?? 0,
            ], $validated['items']);

            // Resolver gateway de pagamento para o método escolhido
            if ($validated['payment_method'] !== 'cash') {
                $gatewayResolver = app(GatewayResolver::class);
                $gateway = $gatewayResolver->resolveForMethod($validated['payment_method']);

                if (! $gateway instanceof PaymentGateway) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Nenhum gateway de pagamento configurado para esta forma de pagamento. Verifique as configurações no painel admin.',
                    ], 422);
                }

                $paymentService = app(PaymentService::class);
                $result = $paymentService->process($order, $gateway, $validated['payment_method']);

                $payment = Payment::create([
                    'order_id' => $order->id,
                    'payment_gateway_id' => $gateway->id,
                    'external_id' => $result['external_id'] ?? null,
                    'status' => $result['status'] ?? Payment::STATUS_PENDING,
                    'amount' => $order->total_amount,
                    'payment_method' => $validated['payment_method'],
                    'metadata' => $result['metadata'] ?? [],
                ]);

                $order->payment_gateway_id = $gateway->id;
                $order->payment_status = $payment->status;
                $order->save();

                return response()->json([
                    'success' => true,
                    'order_number' => $order->order_number,
                    'payment_url' => $result['payment_url'] ?? null,
                    'provider' => $gateway->provider,
                    'message' => 'Pedido criado com sucesso. Você será redirecionado para o pagamento.',
                ]);
            }

            // Fluxo cash (casos especiais; normalmente usado apenas no PDV)
            $order->payment_status = Payment::STATUS_PAID;
            $order->status = Order::STATUS_PAID;
            $order->save();

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

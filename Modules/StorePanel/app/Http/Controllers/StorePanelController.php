<?php

namespace Modules\StorePanel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Catalog\Models\Product;
use Modules\Core\Helpers\UtilsHelper;
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
                'user_id' => Auth::id(),
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

    public function profile(): View
    {
        $user = Auth::user();

        return view('storepanel::profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'phone_secondary' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'document_type' => ['nullable', 'in:cpf,cnpj'],
            'document' => ['nullable', 'string', 'max:18'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'trade_name' => ['nullable', 'string', 'max:255'],
            'state_registration' => ['nullable', 'string', 'max:20'],
            'municipal_registration' => ['nullable', 'string', 'max:20'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            'street' => ['nullable', 'string', 'max:255'],
            'number' => ['nullable', 'string', 'max:20'],
            'complement' => ['nullable', 'string', 'max:255'],
            'neighborhood' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:2'],
            'country' => ['nullable', 'string', 'max:2'],
            'newsletter' => ['nullable', 'boolean'],
            'accepts_marketing' => ['nullable', 'boolean'],
            'preferred_contact' => ['nullable', 'string', 'in:email,phone,whatsapp'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        $validated = $request->validate($rules);

        $user = User::findOrFail(Auth::id());

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => UtilsHelper::onlyDigits($validated['phone'] ?? '') ?: null,
            'phone_secondary' => UtilsHelper::onlyDigits($validated['phone_secondary'] ?? '') ?: null,
            'birth_date' => $validated['birth_date'] ?? null,
            'document_type' => $validated['document_type'] ?? 'cpf',
            'document' => UtilsHelper::onlyDigits($validated['document'] ?? '') ?: null,
            'company_name' => $validated['company_name'] ?? null,
            'trade_name' => $validated['trade_name'] ?? null,
            'state_registration' => $validated['state_registration'] ?? null,
            'municipal_registration' => $validated['municipal_registration'] ?? null,
            'postal_code' => UtilsHelper::onlyDigits($validated['postal_code'] ?? '') ?: null,
            'street' => $validated['street'] ?? null,
            'number' => $validated['number'] ?? null,
            'complement' => $validated['complement'] ?? null,
            'neighborhood' => $validated['neighborhood'] ?? null,
            'city' => $validated['city'] ?? null,
            'state' => $validated['state'] ? strtoupper(substr($validated['state'], 0, 2)) : null,
            'country' => $validated['country'] ? strtoupper(substr($validated['country'], 0, 2)) : null,
            'newsletter' => $request->boolean('newsletter'),
            'accepts_marketing' => $request->boolean('accepts_marketing'),
            'preferred_contact' => $validated['preferred_contact'] ?? 'email',
        ];

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('avatars', 'public');

            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }

            $data['photo'] = $photoPath;
        }

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()
            ->route('pdv.profile')
            ->with('success', 'Perfil atualizado com sucesso.');
    }
}

<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Modules\Catalog\Models\Product;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Sales\Models\Order;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard with metrics.
     */
    public function index(): View
    {
        $now = now();

        $monthlySales = (int) Order::query()
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_SHIPPED])
            ->sum('total_amount');

        $todaySales = (int) Order::query()
            ->whereDate('created_at', $now->toDateString())
            ->sum('total_amount');

        $todayOrdersCount = Order::query()
            ->whereDate('created_at', $now->toDateString())
            ->count();

        $pendingOrdersCount = Order::query()
            ->where('status', Order::STATUS_PENDING)
            ->count();

        $lowStockProducts = Product::query()
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->limit(5)
            ->get();

        $recentOrders = Order::query()
            ->with(['customer', 'user'])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        $monthlySalesFormatted = UtilsHelper::formatMoneyToDisplay($monthlySales / 100);
        $todaySalesFormatted = UtilsHelper::formatMoneyToDisplay($todaySales / 100);

        return view('admin::index', compact(
            'monthlySalesFormatted',
            'todaySalesFormatted',
                'todayOrdersCount',
                'pendingOrdersCount',
                'lowStockProducts',
                'recentOrders'
        ));
    }

        public function profile(): View
        {
            $user = Auth::user();

            return view('admin::profile', compact('user'));
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
                ->route('admin.profile')
                ->with('success', 'Perfil atualizado com sucesso.');
        }
}

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
                'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
                'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            ];

            $validated = $request->validate($rules);

            $user = User::findOrFail(Auth::id());

            $data = [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'phone' => UtilsHelper::onlyDigits($validated['phone'] ?? '') ?: null,
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

<?php

namespace Modules\CustomerPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Sales\Models\Order;

class CustomerPanelController extends Controller
{
    public function index(): View
    {
        $customerId = Auth::id();
        $orders = Order::where('customer_id', $customerId)
            ->with(['items.product'])
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        $totalSpent = Order::where('customer_id', $customerId)
            ->whereIn('status', [Order::STATUS_PAID, Order::STATUS_SHIPPED])
            ->sum('total_amount');

        $ordersCount = Order::where('customer_id', $customerId)->count();

        $totalSpentFormatted = UtilsHelper::formatMoneyToDisplay($totalSpent / 100);

        return view('customerpanel::index', compact('orders', 'totalSpentFormatted', 'ordersCount'));
    }

    public function orders(): View
    {
        $orders = Order::where('customer_id', Auth::id())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('customerpanel::orders.index', compact('orders'));
    }

    public function showOrder(string $order_number): View|RedirectResponse
    {
        $order = Order::where('customer_id', Auth::id())
            ->where('order_number', $order_number)
            ->with(['items.product', 'paymentGateway'])
            ->firstOrFail();

        return view('customerpanel::orders.show', compact('order'));
    }

    public function profile(): View
    {
        $user = Auth::user();

        return view('customerpanel::profile', compact('user'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $rules = [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        $validated = $request->validate($rules);

        $user = User::findOrFail(Auth::id());

        $data = [
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone' => UtilsHelper::onlyDigits($validated['phone'] ?? '') ?: null,
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);

        return redirect()
            ->route('customer.profile')
            ->with('success', 'Perfil atualizado com sucesso.');
    }
}

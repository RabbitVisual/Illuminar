<?php

/**
 * Autor: Reinan Rodrigues
 * Empresa: Vertex Solutions LTDA © 2026
 * Email: r.rodriguesjs@gmail.com
 */

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
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
}

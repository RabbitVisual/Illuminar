<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Catalog\Models\Product;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Inventory\Models\InventoryTransaction;
use Modules\Inventory\Models\Supplier;

class InventoryTransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = InventoryTransaction::with(['product', 'user', 'supplier'])
            ->orderByDesc('created_at');

        if ($request->filled('product_id')) {
            $query->where('product_id', $request->product_id);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(20)->withQueryString();
        $products = Product::orderBy('name')->get();

        return view('inventory::transactions.index', compact('transactions', 'products'));
    }

    public function create(): View
    {
        $products = Product::orderBy('name')->get();
        $suppliers = Supplier::where('is_active', true)->orderBy('name')->get();

        return view('inventory::transactions.create', compact('products', 'suppliers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'type' => ['required', 'in:in,out'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'unit_cost' => ['nullable', 'string'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validated['type'] === 'out') {
            $product = Product::findOrFail($validated['product_id']);
            if ($product->stock < $validated['quantity']) {
                return back()
                    ->withInput()
                    ->withErrors(['quantity' => 'Estoque insuficiente. Disponível: ' . $product->stock . ' unidades.']);
            }
        }

        $unitCost = 0;
        if ($validated['type'] === 'in' && ! empty($validated['unit_cost'])) {
            $unitCost = (int) round((float) UtilsHelper::formatMoneyToDatabase($validated['unit_cost']) * 100);
        }

        InventoryTransaction::create([
            'product_id' => $validated['product_id'],
            'supplier_id' => $validated['supplier_id'] ?? null,
            'user_id' => auth()->id(),
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'unit_cost' => $unitCost,
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()->route('inventory.transactions.index')->with('success', 'Movimentação registrada com sucesso.');
    }
}

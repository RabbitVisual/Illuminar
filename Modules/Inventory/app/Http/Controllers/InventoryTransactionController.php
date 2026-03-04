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

        // Export CSV (limitado para evitar respostas muito grandes)
        if ($request->get('export') === 'csv') {
            $exportQuery = clone $query;
            $transactions = $exportQuery->limit(5000)->get();

            $fileName = 'kardex-' . now()->format('Ymd-His') . '.csv';

            return response()->streamDownload(function () use ($transactions) {
                $handle = fopen('php://output', 'w');
                fputcsv($handle, [
                    'Data/Hora',
                    'Produto',
                    'SKU',
                    'Tipo',
                    'Quantidade',
                    'Responsável',
                    'Fornecedor',
                    'Descrição',
                ]);

                foreach ($transactions as $transaction) {
                    fputcsv($handle, [
                        optional($transaction->created_at)->format('d/m/Y H:i'),
                        optional($transaction->product)->name,
                        optional($transaction->product)->sku,
                        $transaction->isIn() ? 'Entrada' : 'Saída',
                        $transaction->quantity,
                        optional($transaction->user)->full_name,
                        optional($transaction->supplier)->name,
                        $transaction->description,
                    ]);
                }

                fclose($handle);
            }, $fileName, [
                'Content-Type' => 'text/csv; charset=UTF-8',
            ]);
        }

        // Estatísticas rápidas
        $statsQuery = clone $query;
        $totalIn = (clone $statsQuery)->where('type', 'in')->sum('quantity');
        $totalOut = (clone $statsQuery)->where('type', 'out')->sum('quantity');
        $totalMovements = (clone $statsQuery)->count();

        $transactions = $query->paginate(20)->withQueryString();
        $products = Product::orderBy('name')->get();

        $stats = [
            'total_in' => (int) $totalIn,
            'total_out' => (int) $totalOut,
            'total_movements' => (int) $totalMovements,
        ];

        return view('inventory::transactions.index', compact('transactions', 'products', 'stats'));
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

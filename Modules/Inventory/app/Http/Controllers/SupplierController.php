<?php

namespace Modules\Inventory\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Inventory\Models\Supplier;

class SupplierController extends Controller
{
    public function index(): View
    {
        $suppliers = Supplier::orderBy('name')->paginate(15);

        return view('inventory::suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('inventory::suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:18', 'unique:suppliers,cnpj'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $cnpj = UtilsHelper::onlyDigits($validated['cnpj']);
        $phone = UtilsHelper::onlyDigits($validated['phone'] ?? '');

        Supplier::create([
            'name' => $validated['name'],
            'cnpj' => $cnpj,
            'email' => $validated['email'] ?? null,
            'phone' => $phone ?: null,
            'address' => $validated['address'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('inventory.suppliers.index')->with('success', 'Fornecedor criado com sucesso.');
    }

    public function show(Supplier $supplier): RedirectResponse
    {
        return redirect()->route('inventory.suppliers.edit', $supplier);
    }

    public function edit(Supplier $supplier): View
    {
        return view('inventory::suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:18', 'unique:suppliers,cnpj,' . $supplier->id],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['boolean'],
        ]);

        $cnpj = UtilsHelper::onlyDigits($validated['cnpj']);
        $phone = UtilsHelper::onlyDigits($validated['phone'] ?? '');

        $supplier->update([
            'name' => $validated['name'],
            'cnpj' => $cnpj,
            'email' => $validated['email'] ?? null,
            'phone' => $phone ?: null,
            'address' => $validated['address'] ?? null,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('inventory.suppliers.index')->with('success', 'Fornecedor atualizado com sucesso.');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('inventory.suppliers.index')->with('success', 'Fornecedor excluído com sucesso.');
    }
}

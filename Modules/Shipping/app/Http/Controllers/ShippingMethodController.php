<?php

namespace Modules\Shipping\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Shipping\Models\ShippingMethod;

class ShippingMethodController extends Controller
{
    public function index(): View
    {
        $methods = ShippingMethod::orderBy('name')->paginate(15);

        return view('shipping::admin.methods.index', compact('methods'));
    }

    public function create(): View
    {
        $method = new ShippingMethod(['coverage_type' => 'national', 'coverage_data' => []]);

        return view('shipping::admin.methods.create', compact('method'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateMethod($request);

        ShippingMethod::create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'base_price' => $validated['base_price'],
            'delivery_time_days' => (int) $validated['delivery_time_days'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'coverage_type' => $validated['coverage_type'],
            'coverage_data' => $validated['coverage_data'],
        ]);

        return redirect()
            ->route('shipping.methods.index')
            ->with('success', 'Método de entrega criado com sucesso.');
    }

    public function edit(ShippingMethod $method): View
    {
        return view('shipping::admin.methods.edit', compact('method'));
    }

    public function update(Request $request, ShippingMethod $method): RedirectResponse
    {
        $validated = $this->validateMethod($request);

        $method->update([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'base_price' => $validated['base_price'],
            'delivery_time_days' => (int) $validated['delivery_time_days'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'coverage_type' => $validated['coverage_type'],
            'coverage_data' => $validated['coverage_data'],
        ]);

        return redirect()
            ->route('shipping.methods.index')
            ->with('success', 'Método de entrega atualizado com sucesso.');
    }

    public function destroy(ShippingMethod $method): RedirectResponse
    {
        $method->delete();

        return redirect()
            ->route('shipping.methods.index')
            ->with('success', 'Método de entrega removido.');
    }

    protected function validateMethod(Request $request): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'in:correios,motoboy,pickup'],
            'base_price' => ['required', 'string'],
            'delivery_time_days' => ['required', 'integer', 'min:1', 'max:90'],
            'is_active' => ['nullable', 'boolean'],
            'coverage_type' => ['required', 'string', 'in:national,state,cities,zip_codes'],
        ];

        $validated = $request->validate($rules);

        $basePrice = (int) round((float) UtilsHelper::formatMoneyToDatabase($validated['base_price']) * 100);
        if ($basePrice < 1) {
            throw new \InvalidArgumentException('O valor base do frete deve ser maior que zero. O frete nunca é gratuito por padrão.');
        }

        $validated['base_price'] = $basePrice;
        $validated['coverage_data'] = $this->parseCoverageData($request, $validated['coverage_type']);

        return $validated;
    }

    protected function parseCoverageData(Request $request, string $coverageType): ?array
    {
        return match ($coverageType) {
            'cities' => $this->parseCities($request->input('coverage_cities', '')),
            'state' => $request->filled('coverage_states') ? array_map('trim', explode(',', $request->coverage_states)) : [],
            'zip_codes' => $request->filled('coverage_zip_ranges') ? array_map('trim', explode(',', $request->coverage_zip_ranges)) : [],
            default => null,
        };
    }

    protected function parseCities(string $input): array
    {
        if (empty(trim($input))) {
            return [];
        }

        return array_map(fn ($c) => trim($c), array_filter(explode(',', $input)));
    }
}

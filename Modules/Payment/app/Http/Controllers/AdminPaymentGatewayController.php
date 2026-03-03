<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Payment\Models\PaymentGateway;

class AdminPaymentGatewayController extends Controller
{
    public function index(): View
    {
        $gateways = PaymentGateway::orderBy('provider')->orderBy('environment')->get();

        $providers = PaymentGateway::providers();

        return view('payment::admin.index', compact('gateways', 'providers'));
    }

    public function edit(PaymentGateway $gateway): View
    {
        return view('payment::admin.edit', compact('gateway'));
    }

    public function update(Request $request, PaymentGateway $gateway): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'public_key' => ['nullable', 'string', 'max:500'],
            'secret_key' => ['nullable', 'string', 'max:500'],
            'webhook_url' => ['nullable', 'string', 'max:500'],
            'environment' => ['required', 'in:sandbox,production'],
            'is_active' => ['required', 'boolean'],
            'supported_methods' => ['nullable', 'array'],
            'supported_methods.*' => ['string', 'in:pix,credit_card,debit_card,boleto'],
        ]);

        $credentials = $gateway->credentials ?? [];
        if ($request->filled('public_key')) {
            $credentials['public_key'] = $validated['public_key'];
        }
        if ($request->filled('secret_key')) {
            $credentials['secret_key'] = $validated['secret_key'];
        }
        if ($request->filled('webhook_url')) {
            $credentials['webhook_url'] = $validated['webhook_url'];
        }

        if (array_key_exists('supported_methods', $validated)) {
            $credentials['supported_methods'] = $validated['supported_methods'] ?? [];
        }

        $gateway->update([
            'name' => $validated['name'],
            'credentials' => $credentials,
            'environment' => $validated['environment'],
            'is_active' => (bool) $validated['is_active'],
        ]);

        return redirect()
            ->route('payment.admin.gateways.index')
            ->with('success', 'Gateway atualizado com sucesso.');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'provider' => ['required', 'string', 'in:mercadopago,pagarme,stripe'],
            'environment' => ['required', 'in:sandbox,production'],
        ]);

        $exists = PaymentGateway::where('provider', $validated['provider'])
            ->where('environment', $validated['environment'])
            ->exists();

        if ($exists) {
            return redirect()
                ->route('payment.admin.gateways.index')
                ->with('error', 'Este provedor e ambiente já estão configurados.');
        }

        $name = PaymentGateway::providers()[$validated['provider']] . ' (' . ($validated['environment'] === 'production' ? 'Produção' : 'Sandbox') . ')';

        $credentials = [
            'supported_methods' => PaymentGateway::defaultSupportedMethodsFor($validated['provider']),
        ];

        PaymentGateway::create([
            'name' => $name,
            'provider' => $validated['provider'],
            'credentials' => $credentials,
            'environment' => $validated['environment'],
            'is_active' => false,
        ]);

        return redirect()
            ->route('payment.admin.gateways.index')
            ->with('success', 'Gateway criado. Configure as credenciais.');
    }
}

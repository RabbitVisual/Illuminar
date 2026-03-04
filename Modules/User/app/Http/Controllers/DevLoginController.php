<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DevLoginController extends Controller
{
    /**
     * Auto login para usuários de demonstração (somente ambiente local).
     */
    public function loginAs(Request $request, string $type): RedirectResponse
    {
        if (! app()->environment('local')) {
            abort(404);
        }

        $map = [
            'admin' => [
                'email' => 'admin@illuminar.com.br',
                'redirect' => route('admin.index'),
            ],
            'pdv' => [
                'email' => 'pdv-demo@illuminar.com.br',
                'redirect' => route('pdv.index'),
            ],
            'customer' => [
                'email' => 'cliente-demo@illuminar.com.br',
                'redirect' => route('customer.index'),
            ],
        ];

        if (! isset($map[$type])) {
            abort(404);
        }

        $user = User::where('email', $map[$type]['email'])->first();

        if (! $user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Usuário demo não encontrado. Execute os seeders de demo.',
            ]);
        }

        Auth::login($user, true);

        return redirect()->to($map[$type]['redirect']);
    }
}


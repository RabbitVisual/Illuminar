<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Core\Models\SecurityRequest;
use Modules\User\Helpers\RecaptchaHelper;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    /**
     * Exibe o formulário de cadastro.
     */
    public function showRegistrationForm(): View
    {
        return view('user::auth.register');
    }

    /**
     * Processa o cadastro do cliente.
     */
    public function register(Request $request): RedirectResponse
    {
        if (RecaptchaHelper::shouldValidate() && !RecaptchaHelper::verify($request->input('recaptcha_token'))) {
            return back()->withErrors(['email' => __('Falha na verificação de segurança. Tente novamente.')])->withInput();
        }

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'cpf' => ['required', 'string', 'max:14'],
            'phone' => ['required', 'string', 'max:20'],
            'birth_date' => ['required', 'date', 'before:today'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'newsletter' => ['nullable', 'boolean'],
        ]);

        $cpfDigits = UtilsHelper::onlyDigits($validated['cpf']);
        if (strlen($cpfDigits) !== 11) {
            return back()->withErrors(['cpf' => __('CPF deve conter 11 dígitos.')])->withInput();
        }
        $exists = User::where('document_type', 'cpf')
            ->where(function ($q) use ($cpfDigits) {
                $q->where('document', $cpfDigits)->orWhere('cpf', $cpfDigits);
            })
            ->exists();
        if ($exists) {
            return back()->withErrors(['cpf' => __('Este CPF já está cadastrado.')])->withInput();
        }

        $phoneDigits = UtilsHelper::onlyDigits($validated['phone']);
        if (strlen($phoneDigits) < 10) {
            return back()->withErrors(['phone' => __('Informe um telefone válido com DDD.')])->withInput();
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'cpf' => $cpfDigits,
            'document' => $cpfDigits,
            'document_type' => 'cpf',
            'phone' => $phoneDigits,
            'birth_date' => $validated['birth_date'],
            'newsletter' => $request->boolean('newsletter'),
            'status' => 'active',
            'role' => 'customer',
        ]);

        $customerRole = Role::findByName('Customer', 'web');
        if ($customerRole) {
            $user->syncRoles([$customerRole]);
        }

        event(new Registered($user));

        SecurityRequest::create([
            'type' => SecurityRequest::TYPE_REGISTRATION,
            'user_id' => $user->id,
            'email' => $user->email,
            'cpf' => $user->cpf,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => SecurityRequest::STATUS_COMPLETED,
        ]);

        Auth::login($user);

        return redirect()->intended(route('core.index'));
    }
}

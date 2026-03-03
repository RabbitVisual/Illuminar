<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\User\Helpers\RecaptchaHelper;

class AuthController extends Controller
{
    /**
     * Exibe o formulário de login.
     */
    public function showLoginForm(): View
    {
        return view('user::auth.login');
    }

    /**
     * Processa o login do usuário (por e-mail ou CPF).
     */
    public function login(Request $request): RedirectResponse
    {
        if (RecaptchaHelper::shouldValidate() && !RecaptchaHelper::verify($request->input('recaptcha_token'))) {
            throw ValidationException::withMessages(['email' => __('Falha na verificação de segurança. Tente novamente.')]);
        }

        $loginType = $request->input('login_type', 'email');

        if ($loginType === 'cpf') {
            $validated = $request->validate([
                'login_type' => ['in:cpf'],
                'cpf' => ['required', 'string'],
                'password' => ['required'],
            ]);
            $cpf = UtilsHelper::onlyDigits($validated['cpf']);
            if (strlen($cpf) !== 11) {
                throw ValidationException::withMessages(['cpf' => __('CPF inválido.')]);
            }
            $user = User::where('document_type', 'cpf')
                ->where(function ($q) use ($cpf) {
                    $q->where('document', $cpf)->orWhere('cpf', $cpf);
                })
                ->first();
            if (!$user || !Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages(['cpf' => __('As credenciais informadas não conferem.')]);
            }
            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('core.index'));
        }

        $credentials = $request->validate([
            'login_type' => ['nullable', 'in:email'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt([
            'email' => $credentials['email'],
            'password' => $credentials['password'],
        ], $remember)) {
            $request->session()->regenerate();

            return redirect()->intended(route('core.index'));
        }

        return back()->withErrors([
            'email' => __('As credenciais informadas não conferem.'),
        ])->onlyInput('email');
    }

    /**
     * Encerra a sessão do usuário.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

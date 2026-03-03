<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Modules\Core\Helpers\UtilsHelper;
use Modules\Core\Models\SecurityRequest;
use Modules\User\Helpers\RecaptchaHelper;

class ForgotPasswordController extends Controller
{
    /**
     * Exibe o formulário de esqueci senha (e-mail).
     */
    public function showRequestForm(): View
    {
        return view('user::auth.forgot-password');
    }

    /**
     * Envia o link de redefinição por e-mail.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        SecurityRequest::create([
            'type' => SecurityRequest::TYPE_PASSWORD_RESET_EMAIL,
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status === Password::RESET_LINK_SENT ? SecurityRequest::STATUS_PENDING : SecurityRequest::STATUS_FAILED,
            'metadata' => ['message' => $status],
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Exibe o formulário de esqueci senha (CPF + data de nascimento).
     */
    public function showRequestFormCpf(): View
    {
        return view('user::auth.forgot-password-cpf');
    }

    /**
     * Valida CPF + data de nascimento e envia link de redefinição por e-mail.
     */
    public function sendResetLinkCpf(Request $request): RedirectResponse
    {
        if (RecaptchaHelper::shouldValidate() && !RecaptchaHelper::verify($request->input('recaptcha_token'))) {
            return back()->withErrors(['cpf' => __('Falha na verificação de segurança. Tente novamente.')]);
        }

        $validated = $request->validate([
            'cpf' => ['required', 'string'],
            'birth_date' => ['required', 'date'],
        ]);

        $cpf = UtilsHelper::onlyDigits($validated['cpf']);
        if (strlen($cpf) !== 11) {
            return back()->withErrors(['cpf' => __('CPF inválido.')]);
        }

        $user = User::where('document_type', 'cpf')
            ->where(function ($q) use ($cpf) {
                $q->where('document', $cpf)->orWhere('cpf', $cpf);
            })
            ->whereDate('birth_date', $validated['birth_date'])
            ->first();

        if (!$user) {
            SecurityRequest::create([
                'type' => SecurityRequest::TYPE_PASSWORD_RESET_CPF,
                'cpf' => $cpf,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'status' => SecurityRequest::STATUS_FAILED,
                'metadata' => ['reason' => 'user_not_found'],
            ]);

            return back()->withErrors(['cpf' => __('Não encontramos uma conta com esse CPF e data de nascimento.')]);
        }

        $status = Password::sendResetLink(['email' => $user->email]);

        SecurityRequest::create([
            'type' => SecurityRequest::TYPE_PASSWORD_RESET_CPF,
            'user_id' => $user->id,
            'email' => $user->email,
            'cpf' => $cpf,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'status' => $status === Password::RESET_LINK_SENT ? SecurityRequest::STATUS_PENDING : SecurityRequest::STATUS_FAILED,
            'metadata' => ['message' => $status],
        ]);

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('password.request')->with('status', __('Enviamos um link de redefinição de senha para o e-mail cadastrado nesta conta.'));
        }

        return back()->withErrors(['cpf' => __($status)]);
    }

    /**
     * Exibe o formulário de redefinir senha.
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('user::auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Redefine a senha do usuário.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill(['password' => $password])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __('Sua senha foi redefinida. Faça login com a nova senha.'));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}

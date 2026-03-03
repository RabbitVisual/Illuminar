<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Core\Models\Setting;

class SecuritySettingsController extends Controller
{
    public function index(): View
    {
        $recaptchaEnabled = Setting::get('security.recaptcha_enabled', false);
        $recaptchaSiteKey = Setting::get('security.recaptcha_v3_site_key', '');
        $recaptchaSecretKey = Setting::get('security.recaptcha_v3_secret_key', '');
        $twoFactorEnabled = Setting::get('security.two_factor_enabled', false);

        return view('admin::settings.security', compact(
            'recaptchaEnabled',
            'recaptchaSiteKey',
            'recaptchaSecretKey',
            'twoFactorEnabled'
        ));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'recaptcha_enabled' => ['nullable', 'boolean'],
            'recaptcha_v3_site_key' => ['nullable', 'string', 'max:500'],
            'recaptcha_v3_secret_key' => ['nullable', 'string', 'max:500'],
            'two_factor_enabled' => ['nullable', 'boolean'],
        ]);

        Setting::set('security.recaptcha_enabled', $request->boolean('recaptcha_enabled'), 'boolean', 'security');
        if ($request->filled('recaptcha_v3_site_key')) {
            Setting::set('security.recaptcha_v3_site_key', $request->recaptcha_v3_site_key, 'string', 'security');
        }
        if ($request->filled('recaptcha_v3_secret_key')) {
            Setting::set('security.recaptcha_v3_secret_key', $request->recaptcha_v3_secret_key, 'string', 'security');
        }
        Setting::set('security.two_factor_enabled', $request->boolean('two_factor_enabled'), 'boolean', 'security');

        return redirect()->route('admin.settings.security')->with('success', 'Configurações de segurança atualizadas.');
    }
}

<?php

namespace Modules\User\Helpers;

use Illuminate\Support\Facades\Http;
use Modules\Core\Models\Setting;

class RecaptchaHelper
{
    public static function verify(?string $token, float $minScore = 0.5): bool
    {
        if (empty($token)) {
            return false;
        }

        $secret = Setting::get('security.recaptcha_v3_secret_key', '');
        if (empty($secret)) {
            return true;
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secret,
            'response' => $token,
        ]);

        if (!$response->successful()) {
            return false;
        }

        $data = $response->json();
        if (!($data['success'] ?? false)) {
            return false;
        }

        $score = (float) ($data['score'] ?? 0);

        return $score >= $minScore;
    }

    public static function shouldValidate(): bool
    {
        return (bool) Setting::get('security.recaptcha_enabled', false);
    }
}

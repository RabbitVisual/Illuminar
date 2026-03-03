<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
    ];

    protected static array $encryptedKeys = [
        'security.recaptcha_v3_secret_key',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = 'setting.' . $key;

        return Cache::remember($cacheKey, 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->getCastedValueAttribute() : $default;
        });
    }

    public static function set(string $key, mixed $value, string $type = 'string', string $group = 'general'): self
    {
        $stringValue = match (true) {
            is_bool($value) => $value ? '1' : '0',
            is_array($value) || is_object($value) => json_encode($value),
            default => (string) $value,
        };

        if (in_array($key, self::$encryptedKeys, true)) {
            if ($stringValue === '') {
                $existing = static::where('key', $key)->first();
                return $existing ?? static::create(['key' => $key, 'value' => '', 'type' => $type, 'group' => $group]);
            }
            $stringValue = encrypt($stringValue);
        }

        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $stringValue,
                'type' => $type,
                'group' => $group,
            ]
        );

        Cache::forget('setting.' . $key);

        return $setting;
    }

    public function getCastedValueAttribute(): mixed
    {
        $value = $this->value;

        if (in_array($this->key, self::$encryptedKeys, true) && $value !== null && $value !== '') {
            try {
                $value = decrypt($value);
            } catch (\Throwable) {
                $value = null;
            }
        }

        return match ($this->type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json' => is_string($value) ? json_decode($value, true) : $value,
            'integer' => (int) $value,
            default => $value,
        };
    }
}

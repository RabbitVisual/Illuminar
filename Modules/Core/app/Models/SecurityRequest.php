<?php

namespace Modules\Core\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityRequest extends Model
{
    public const TYPE_PASSWORD_RESET_EMAIL = 'password_reset_email';

    public const TYPE_PASSWORD_RESET_CPF = 'password_reset_cpf';

    public const TYPE_REGISTRATION = 'registration';

    public const STATUS_PENDING = 'pending';

    public const STATUS_COMPLETED = 'completed';

    public const STATUS_EXPIRED = 'expired';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'type',
        'user_id',
        'email',
        'cpf',
        'ip_address',
        'user_agent',
        'status',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function typeLabel(string $type): string
    {
        return match ($type) {
            self::TYPE_PASSWORD_RESET_EMAIL => 'Recuperação de senha (e-mail)',
            self::TYPE_PASSWORD_RESET_CPF => 'Recuperação de senha (CPF)',
            self::TYPE_REGISTRATION => 'Cadastro',
            default => $type,
        };
    }

    public static function statusLabel(string $status): string
    {
        return match ($status) {
            self::STATUS_PENDING => 'Pendente',
            self::STATUS_COMPLETED => 'Concluído',
            self::STATUS_EXPIRED => 'Expirado',
            self::STATUS_FAILED => 'Falhou',
            default => $status,
        };
    }

    public function getMaskedCpfAttribute(): ?string
    {
        if (!$this->cpf || strlen($this->cpf) < 4) {
            return $this->cpf;
        }

        return '***.' . substr($this->cpf, -7, 3) . '.***-**';
    }
}

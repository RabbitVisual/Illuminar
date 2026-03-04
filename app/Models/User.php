<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'phone_secondary',
        'photo',
        'birth_date',
        'document_type',
        'document',
        'cpf',
        'company_name',
        'trade_name',
        'state_registration',
        'municipal_registration',
        'postal_code',
        'street',
        'number',
        'complement',
        'neighborhood',
        'city',
        'state',
        'country',
        'role',
        'status',
        'permissions',
        'newsletter',
        'accepts_marketing',
        'preferred_contact',
        'email_verified_at',
        'phone_verified_at',
        'last_login_at',
        'last_login_ip',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birth_date' => 'date',
            'last_login_at' => 'datetime',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}") ?: (string) $this->email;
    }

    /**
     * Alias for full_name (compatibility with layouts that use ->name).
     */
    public function getNameAttribute(): string
    {
        return $this->full_name;
    }

    /**
     * Get the user's photo URL.
     */
    public function getPhotoUrlAttribute(): string
    {
        return $this->photo ? asset('storage/' . $this->photo) : asset('assets/images/default-avatar.png');
    }

    /**
     * Document (CPF/CNPJ) formatted for display in forms.
     */
    public function getDocumentFormattedAttribute(): ?string
    {
        $digits = preg_replace('/\D/', '', (string) $this->document);
        if (strlen($digits) === 11) {
            return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $digits);
        }
        if (strlen($digits) === 14) {
            return preg_replace('/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/', '$1.$2.$3/$4-$5', $digits);
        }

        return $this->document;
    }
}

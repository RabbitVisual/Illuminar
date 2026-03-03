<?php

namespace Modules\Shipping\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Core\Helpers\UtilsHelper;

class ShippingMethod extends Model
{
    public const TYPE_CORREIOS = 'correios';

    public const TYPE_MOTOBOY = 'motoboy';

    public const TYPE_PICKUP = 'pickup';

    public const COVERAGE_NATIONAL = 'national';

    public const COVERAGE_STATE = 'state';

    public const COVERAGE_CITIES = 'cities';

    public const COVERAGE_ZIP_CODES = 'zip_codes';

    protected $fillable = [
        'name',
        'type',
        'base_price',
        'delivery_time_days',
        'is_active',
        'coverage_type',
        'coverage_data',
    ];

    protected $casts = [
        'base_price' => 'integer',
        'delivery_time_days' => 'integer',
        'is_active' => 'boolean',
        'coverage_data' => 'array',
    ];

    public function shipments(): HasMany
    {
        return $this->hasMany(Shipment::class);
    }

    public function getBasePriceFormattedAttribute(): string
    {
        return UtilsHelper::formatMoneyToDisplay($this->base_price / 100);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_CORREIOS => 'Correios',
            self::TYPE_MOTOBOY => 'Motoboy',
            self::TYPE_PICKUP => 'Retirada',
            default => ucfirst($this->type),
        };
    }

    public function getCoverageTypeLabelAttribute(): string
    {
        return match ($this->coverage_type) {
            self::COVERAGE_NATIONAL => 'Nacional',
            self::COVERAGE_STATE => 'Por Estado',
            self::COVERAGE_CITIES => 'Por Cidades',
            self::COVERAGE_ZIP_CODES => 'Por CEP',
            default => ucfirst($this->coverage_type),
        };
    }

    public static function types(): array
    {
        return [
            self::TYPE_CORREIOS => 'Correios',
            self::TYPE_MOTOBOY => 'Motoboy',
            self::TYPE_PICKUP => 'Retirada no Local',
        ];
    }

    public static function coverageTypes(): array
    {
        return [
            self::COVERAGE_NATIONAL => 'Todo o Brasil',
            self::COVERAGE_STATE => 'Por Estado (UF)',
            self::COVERAGE_CITIES => 'Por Cidades',
            self::COVERAGE_ZIP_CODES => 'Por Faixa de CEP',
        ];
    }
}

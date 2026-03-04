<?php

namespace Modules\Sales\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use Modules\Sales\Models\Coupon;

class CouponService
{
    /**
     * Aplica um cupom sobre um subtotal (em centavos) e retorna o valor de desconto.
     *
     * @return array{coupon: Coupon, discount: int}
     */
    public function apply(string $code, int $subtotal): array
    {
        $normalizedCode = strtoupper(trim($code));

        if ($subtotal <= 0) {
            throw new InvalidArgumentException('Não é possível aplicar cupom em um pedido vazio.');
        }

        /** @var Coupon|null $coupon */
        $coupon = Coupon::query()
            ->whereRaw('UPPER(code) = ?', [$normalizedCode])
            ->where('is_active', true)
            ->first();

        if (! $coupon) {
            throw new InvalidArgumentException('Cupom inválido ou inexistente.');
        }

        $now = Carbon::now();

        if ($coupon->valid_from && $coupon->valid_from->isAfter($now)) {
            throw new InvalidArgumentException('Este cupom ainda não está válido.');
        }

        if ($coupon->valid_until && $coupon->valid_until->isBefore($now)) {
            throw new InvalidArgumentException('Este cupom está expirado.');
        }

        if ($subtotal < $coupon->min_order_total) {
            throw new InvalidArgumentException('Valor mínimo não atingido para uso deste cupom.');
        }

        $discount = $this->calculateDiscount($coupon, $subtotal);

        if ($discount <= 0) {
            throw new InvalidArgumentException('Não foi possível aplicar desconto com este cupom.');
        }

        return [
            'coupon' => $coupon,
            'discount' => $discount,
        ];
    }

    protected function calculateDiscount(Coupon $coupon, int $subtotal): int
    {
        if ($coupon->type === Coupon::TYPE_FIXED) {
            return min($coupon->value, $subtotal);
        }

        // Percentual (0–100)
        $percent = max(0, min(100, $coupon->value));

        return (int) floor($subtotal * $percent / 100);
    }
}


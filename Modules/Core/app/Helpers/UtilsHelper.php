<?php

namespace Modules\Core\Helpers;

class UtilsHelper
{
    /**
     * Formata valor monetário (ex: "R$ 1.500,50") para o formato de banco de dados (ex: "1500.50").
     * Remove "R$", pontos de milhar e troca vírgula decimal por ponto.
     *
     * @param  string|null  $value  Valor formatado (ex: "R$ 1.500,50" ou "1.500,50")
     * @return string Valor numérico para banco (ex: "1500.50") ou "0.00" se vazio
     */
    public static function formatMoneyToDatabase(?string $value): string
    {
        if ($value === null || trim($value) === '') {
            return '0.00';
        }

        $cleaned = preg_replace('/[^\d,.-]/', '', $value);
        $cleaned = str_replace('.', '', $cleaned);
        $cleaned = str_replace(',', '.', $cleaned);

        if ($cleaned === '' || $cleaned === '.') {
            return '0.00';
        }

        $float = (float) $cleaned;

        return number_format($float, 2, '.', '');
    }

    /**
     * Formata valor do banco de dados para exibição em moeda brasileira.
     *
     * @param  float|string|null  $value  Valor numérico
     * @param  bool  $withSymbol  Incluir símbolo R$
     */
    public static function formatMoneyToDisplay(float|string|null $value, bool $withSymbol = true): string
    {
        if ($value === null || $value === '') {
            return $withSymbol ? 'R$ 0,00' : '0,00';
        }

        $float = (float) $value;
        $formatted = number_format($float, 2, ',', '.');

        return $withSymbol ? "R$ {$formatted}" : $formatted;
    }

    /**
     * Remove todos os caracteres não numéricos de uma string (útil para CPF, CNPJ, telefone).
     */
    public static function onlyDigits(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return preg_replace('/\D/', '', $value);
    }
}

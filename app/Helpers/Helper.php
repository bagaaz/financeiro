<?php

namespace App\Helpers;

final class Helper
{
    /**
     * Converte uma string no formato de moeda brasileira para float.
     *
     * @param string $value Valor formatado, ex: "R$ 1.234,56"
     * @return float
     */
    public static function realToFloat($value): float
    {
        $value = str_replace(['R$', "\u{A0}", ' '], '', $value);
        $value = str_replace('.', '', $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    /**
     * Converte um valor float para uma string no formato de moeda brasileira.
     *
     * @param float $value Valor numérico, ex: 1234.56
     * @return string Valor formatado, ex: "R$ 1.234,56"
     */
    public static function floatToReal($value): string
    {
        return 'R$ ' . number_format($value, 2, ',', '.');
    }
}

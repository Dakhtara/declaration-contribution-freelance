<?php

namespace App\Util;

class CurrencyFormatter
{
    public function toFloat(int $price): float
    {
        return $price / 100;
    }

    public function toCurrency(int $price, string $locale = 'fr_FR', string $currency = 'EUR'): string
    {
        $numberFormatter = new \NumberFormatter($locale, \NumberFormatter::CURRENCY);

        return $numberFormatter->formatCurrency($this->toFloat($price), $currency);
    }
}

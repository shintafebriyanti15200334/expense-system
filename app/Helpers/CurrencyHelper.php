<?php

namespace App\Helpers;

class CurrencyHelper
{
    public static function rupiah(float|int $value): string
    {
        return 'Rp ' . number_format($value, 0, ',', '.');
    }
}
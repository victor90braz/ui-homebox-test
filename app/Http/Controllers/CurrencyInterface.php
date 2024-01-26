<?php

namespace App\Http\Controllers;

interface CurrencyInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function convert(string $from, string $to, float $amount): array;
}

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

class CurrencyController extends Controller
{
    /**
     * @param CurrencyInterface $currency
     * @return array
     */
    public function store(CurrencyInterface $currency)
    {
        $validateData = \request()->validate([
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        $response = $currency->convert($validateData['from'], $validateData['to'], $validateData['amount']);

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];
    }
}








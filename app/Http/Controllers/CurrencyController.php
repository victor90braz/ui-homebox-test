<?php

namespace App\Http\Controllers;

interface CurrencyInterface
{
    /**
     * Convert the given amount from one currency to another.
     *
     * @param float $amount
     * @param string $from
     * @param string $to
     * @return mixed
     */
    public function convert(float $amount, string $from, string $to);
}

class CurrencyController extends Controller
{

    /**
     * @param CurrencyInterface $currency
     * @return array
     * @throws \Exception
     */
    public function convert(CurrencyInterface $currency)
    {
        $validateData = request()->validate([
            'amount' => ['required', 'numeric', ],
            'from' => ['required', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
        ]);

        $amount = $validateData['amount'];
        $from = $validateData['from'];
        $to = $validateData['to'];

        $response = $currency->convert($amount, $from, $to);

        return [
            'converted' => $response['amount'],
        ];
    }
}






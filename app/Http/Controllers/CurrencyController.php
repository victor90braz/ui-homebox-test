<?php

namespace App\Http\Controllers;

use App\Services\AmdorenService;

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
    public function convert(string $from, string $to, float $amount, );
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
            'from' => ['required', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
            'amount' => ['required', 'numeric', ],
        ]);

        $from = $validateData['from'];
        $to = $validateData['to'];
        $amount = $validateData['amount'];

        $response = $currency->convert( $from, $to, $amount);

       dd($response);

        return [
            'converted' => $response['amount'],
        ];
    }
}








<?php

namespace App\Http\Controllers;
interface CurrencyInterface
{
    /**
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return mixed
     */
    public function convert(string $from, string $to, float $amount);
}
class CurrencyController extends Controller
{
    /**
     * @param CurrencyInterface $currency
     * @return array
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

        $response = $currency->convert($from, $to, $amount);

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];
    }
}








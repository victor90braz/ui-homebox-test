<?php

namespace App\Http\Controllers;
use App\Services\AmdorenService;
use App\Services\FixerService;

interface CurrencyInterface
{
    /**
     * @param object $service
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function convert(object $service, string $from, string $to, float $amount): array;
}

class CurrencyController extends Controller
{
    /**
     * @param CurrencyInterface $currency
     * @return array
     */
    public function convert(CurrencyInterface $currency, string $from, string $to, float $amount)
    {
        // Call the convert method on the provided currency service
        $response = $currency->convert(new AmdorenService(), $from, $to, $amount);

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];
    }
}








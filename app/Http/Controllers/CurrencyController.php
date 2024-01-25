<?php

namespace App\Http\Controllers;
use App\Services\AmdorenService;
use App\Services\FixerService;

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

    /**
     * @param AmdorenService $amdorenService
     * @return array
     */
    public function convertAmdoren(AmdorenService $amdorenService)
    {
        $validateData = request()->validate([
            'from' => ['required', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
            'amount' => ['required', 'numeric'],
        ]);

        $from = $validateData['from'];
        $to = $validateData['to'];
        $amount = $validateData['amount'];

        $response = $amdorenService->convert($from, $to, $amount);

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];
    }

    /**
     * @param FixerService $fixerService
     * @return array
     */
    public function convertFixer(FixerService $fixerService)
    {
        $validateData = request()->validate([
            'from' => ['required', 'string', 'size:3'],
            'to' => ['required', 'string', 'size:3'],
            'amount' => ['required', 'numeric'],
        ]);

        $from = $validateData['from'];
        $to = $validateData['to'];
        $amount = $validateData['amount'];

        $response = $fixerService->convert($from, $to, $amount);

        return [
            'converted' => $response['amount'],
            'currency' => $response['to'],
        ];
    }
}








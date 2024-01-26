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
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CurrencyInterface $currency)
    {
        $validateData = request()->validate([
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        $response = $currency->convert($validateData['from'], $validateData['to'], $validateData['amount']);

        if (array_key_exists('to', $response) && array_key_exists('amount', $response)) {
            return [
                'converted' => $response['amount'],
                'currency' => $response['to'],
            ];
        } else {
            return redirect("/")->withErrors(['error' => 'Conversion failed. Please check your input and try again.']);
        }
    }
}









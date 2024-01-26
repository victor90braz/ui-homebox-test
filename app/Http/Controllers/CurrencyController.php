<?php

namespace App\Http\Controllers;

class CurrencyController extends Controller
{
    const QUERY_PARAMETER_AS_DEFAULT = 'GBP';

    /**
     * @param CurrencyInterface $currency
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CurrencyInterface $currency)
    {
        $validateData = request()->validate([
            'from' => ['sometimes', 'required', 'string'],
            'to' => ['required', 'string'],
            'amount' => ['required', 'numeric'],
        ]);

        $validateData['from'] = self::QUERY_PARAMETER_AS_DEFAULT;

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









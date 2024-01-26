<?php

namespace App\Http\Controllers;

use App\Services\AmdorenService;

class AmdorenController extends Controller
{
    public function convert()
    {
        $currencyController = app(CurrencyController::class);
        return $currencyController->store(new AmdorenService());
    }
}

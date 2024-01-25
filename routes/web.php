<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currency/api/convert', [\App\Http\Controllers\CurrencyController::class, 'convert']);

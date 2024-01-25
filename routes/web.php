<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currency/api/convert', [\App\Http\Controllers\CurrencyController::class, 'convert']);
Route::get('/currency/api/convert-amdoren', [\App\Http\Controllers\CurrencyController::class, 'convertAmdoren']);
Route::get('/currency/api/convert-fixer', [\App\Http\Controllers\CurrencyController::class, 'convertFixer']);

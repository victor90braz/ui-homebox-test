<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use Illuminate\Routing\Middleware\SubstituteBindings;

Route::get('/currency/api/convert', [\App\Http\Controllers\CurrencyController::class, 'convert'])
    ->withoutMiddleware(SubstituteBindings::class);

<?php

use App\Http\Controllers\BitcoinExchangeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'bitcoin', 'as' => 'bitcoin.'], function(\Illuminate\Routing\Router $route) {
    $route->get('', [BitcoinExchangeController::class, 'list'])->name('index');
    $route->get('rate/{timestamp?}', [BitcoinExchangeController::class, 'getRate'])->name('rate');
    $route->get('average/{timestamp1?}/{timestamp2?}', [BitcoinExchangeController::class, 'rateDifference'])->name('average');
});

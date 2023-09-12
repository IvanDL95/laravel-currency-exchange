<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use Illuminate\Http\Request;

class BitcoinExchangeController extends Controller
{
    public function getRate(Request $request, $timestamp = null) {
        $timestamp = $timestamp ?? now();
        $exchangeRate = ExchangeRate::whereTime('timestamp', '<=', $timestamp)->orderBy('timestamp', 'desc')->firstOrFail();

        return response()->json([
            'data' => $exchangeRate,
        ]);
    }
}

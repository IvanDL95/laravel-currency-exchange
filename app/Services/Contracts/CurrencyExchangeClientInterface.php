<?php

namespace App\Services\Contracts;

interface CurrencyExchangeClientInterface {
    public function getCurrentRate($fromCurrency, $toCurrency);
}

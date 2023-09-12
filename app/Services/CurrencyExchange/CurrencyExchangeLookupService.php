<?php

namespace App\Services\CurrencyExchange;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Services\Contracts\CurrencyExchangeClientInterface;

class CurrencyExchangeLookupService
{
    /**
    * The base uri.
    *
    * @var CurrencyExchangeClientInterface
    */
    protected $exchangeClient;

    /**
    * The currencies.
    *
    * @var array<string,Currency>
    */
    protected $currencies;

    public function __construct(CurrencyExchangeClientInterface $exchangeClient, array $currencies) {
        $this->exchangeClient = $exchangeClient;
        $this->currencies = $currencies;
    }

    public function currentExchangeRate() {
        $currentRate = $this->exchangeClient->getCurrentRate($this->currencies['from'], $this->currencies['to']);

        $currencyFrom = Currency::firstOrCreate([
            'iso_name' => $currentRate['from']
        ]);
        $currencyTo = Currency::firstOrCreate([
            'iso_name' => $currentRate['to']
        ]);

        $exchangeRate = new ExchangeRate([
            'rate' => $currentRate['rate'],
            'timestamp' => now(),
        ]);

        $exchangeRate->from()->associate($currencyFrom);
        $exchangeRate->to()->associate($currencyTo);
        $exchangeRate->save();

        return $exchangeRate;
    }
}

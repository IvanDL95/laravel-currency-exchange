<?php

namespace App\Services\CurrencyExchange\Clients;

use App\Services\Contracts\CurrencyExchangeClientInterface;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

class SimpleCurrencyExchangeClientService implements CurrencyExchangeClientInterface
{
    /**
    * The base uri.
    *
    * @var string
    */
    protected $exchange_uri;

    /**
    * The uri parameters builder.
    *
    * @var callable
    */
    protected $parameters;

    /**
    * The response adapter.
    *
    * @var callable
    */
    protected $response_adapter;

    public function __construct(string $exchange_uri, $parameters, $response_adapter = null) {
        $this->exchange_uri = $exchange_uri;
        $this->parameters = $parameters;
        $this->response_adapter = $response_adapter;
    }

    public function getCurrentRate($fromCurrency, $toCurrency) {
        try {
            $urlParameters = call_user_func($this->parameters, $fromCurrency, $toCurrency);
            $response = $this->getClient()->get("{+endpoint}$urlParameters");
            $result = json_decode($response->getBody(), true);

            return $this->response_adapter
                ? call_user_func($this->response_adapter, $result)
                : $result
            ;
        } catch (\Throwable $th) {
            throw new ServiceUnavailableHttpException(null, 'Exchange unavailable', $th);
        }
    }

    protected function getClient() {
        // Http::createClient();
        return Http::withUrlParameters([
            'endpoint' => $this->exchange_uri,
        ]);
    }
}

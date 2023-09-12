<?php

namespace App\Providers;

use App\Services\Contracts\CurrencyExchangeClientInterface;
use App\Services\CurrencyExchange\Clients\SimpleCurrencyExchangeClientService;
use App\Services\CurrencyExchange\CurrencyExchangeLookupService;
use Illuminate\Support\ServiceProvider;

class CurrencyExchangeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void {
        $config = $this->app['config']->get('services.exchange');

        $this->registerClientService($config);
        $this->registerLookupService($config);
    }

    protected function registerClientService(array $config) {
        $this->app->bind(CurrencyExchangeClientInterface::class, function ($app) use ($config) {
            return $app->makeWith(SimpleCurrencyExchangeClientService::class, [
                'exchange_uri' => $config['url'],
                'parameters' => function($from, $to) {
                    return "/{$from}/{$to}";
                },
                'response_adapter' => function($apiResponseData) {
                    // 'lprice' => '26090.4',
                    // 'curr1' => 'BTC',
                    // 'curr2' => 'USD',
                    return [
                        'from' => $apiResponseData['curr1'],
                        'to' => $apiResponseData['curr2'],
                        'rate' => $apiResponseData['lprice'],
                    ];
                },
            ]);
        });
    }

    protected function registerLookupService(array $config) {
        $this->app->when(CurrencyExchangeLookupService::class)
            ->needs('$currencies')
            ->give([
                'from' => 'BTC',
                'to' => 'USD',
            ])
        ;
    }
}

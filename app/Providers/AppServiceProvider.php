<?php

namespace App\Providers;

use App\Http\Controllers\BitcoinExchangeController;
use App\Services\Contracts\CurrencyInformationInterface;
use App\Services\BitcoinInformationService;
use App\Repositories\EloquentRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->when(BitcoinExchangeController::class)
            ->needs(CurrencyInformationInterface::class)
            ->give(function () {
                return new BitcoinInformationService(new EloquentRepository());
            });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

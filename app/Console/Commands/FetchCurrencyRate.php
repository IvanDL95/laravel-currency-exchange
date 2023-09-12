<?php

namespace App\Console\Commands;

use App\Services\Contracts\CurrencyExchangeClientInterface;
use App\Services\CurrencyExchange\CurrencyExchangeClientService;
use App\Services\CurrencyExchange\CurrencyExchangeLookupService;
use Illuminate\Console\Command;

class FetchCurrencyRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exchange:fetch-rate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyExchangeLookupService $exchangeService)
    {
        $data = $exchangeService->currentExchangeRate();
    }
}

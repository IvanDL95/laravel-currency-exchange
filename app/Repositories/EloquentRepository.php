<?php

namespace App\Repositories;

use App\Models\ExchangeRate;
use App\Services\Contracts\CurrencyRepository;
use Illuminate\Support\Carbon;

class EloquentRepository implements CurrencyRepository
{
    public function getFromTimestamp(Carbon $timestamp) {
        return ExchangeRate::whereTime('timestamp', '<=', $timestamp)->orderBy('timestamp', 'desc')->firstOrFail()->rate;
    }

    public function getRange(Carbon $timestamp1, Carbon $timestamp2) {
        return ExchangeRate::whereBetween('timestamp', [$timestamp1, $timestamp2])->orderBy('timestamp', 'desc')->get()->map(function($rate) {
            return $rate->rate;
        });
    }

    public function getPage(Carbon $timestamp1, Carbon $timestamp2) {
        return ExchangeRate::whereBetween('timestamp', [$timestamp1, $timestamp2])->orderBy('timestamp', 'desc')->paginate();
    }
}

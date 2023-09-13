<?php

namespace App\Services\Contracts;

use Illuminate\Support\Carbon;

interface CurrencyInformationInterface
{
    public function getRate(Carbon $timestamp);

    public function getAverageDifference(Carbon $timestamp1, Carbon $timestamp2);

    public function getListing($timestampFilter);
}

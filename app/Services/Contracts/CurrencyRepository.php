<?php

namespace App\Services\Contracts;

use Illuminate\Support\Carbon;

interface CurrencyRepository
{
    public function getFromTimestamp(Carbon $timestamp);

    public function getRange(Carbon $timestamp1, Carbon $timestamp2);

    public function getPage(Carbon $timestamp1, Carbon $timestamp2);
}

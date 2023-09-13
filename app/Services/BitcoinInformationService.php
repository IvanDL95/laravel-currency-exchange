<?php

namespace App\Services;

use App\Services\Contracts\CurrencyInformationInterface;
use App\Services\Contracts\CurrencyRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Fluent;
use RuntimeException;

class BitcoinInformationService implements CurrencyInformationInterface
{
    /**
    * The base uri.
    *
    * @var CurrencyRepository
    */
    protected $repository;

    public function __construct(CurrencyRepository $repository) {
        $this->repository = $repository;
    }

    public function getRate(Carbon $timestamp) {
        return new Fluent([
            'rate' => $this->repository->getFromTimestamp($timestamp)
        ]);
    }

    public function getAverageDifference(Carbon $timestamp1, Carbon $timestamp2) {
        $range = $this->repository->getRange($timestamp1, $timestamp2);

        if ($range->count() < 2) {
            throw new RuntimeException('The range has a single rate');
        }

        $average = $range->avg();
        return [
            'avg' => $average,
            'max_perc' => $average * 100 / $range->max()
        ];
    }

    public function getListing($timestampFilter) {
        return $this->repository->getPage($timestampFilter['after'], $timestampFilter['before']);
    }
}

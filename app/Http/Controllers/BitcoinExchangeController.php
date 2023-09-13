<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Services\Contracts\CurrencyInformationInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BitcoinExchangeController extends Controller
{
    /**
    * The bitcoin info service
    *
    * @var CurrencyInformationInterface
    */
    protected $informationService;

    public function __construct(CurrencyInformationInterface $informationService) {
        $this->informationService = $informationService;
    }

    // a) Obtener el precio del Bitcoin en cierto timestamp.
    public function getRate(Request $request, $timestamp = null) {
        $timestamp = $timestamp ?? now();
        return response()->json([
            'data' => $this->informationService->getRate($timestamp),
        ]);
    }

    // b) Conocer el promedio de valor entre dos timestamps así como la diferencia porcentual entre ese valor promedio y el valor máximo almacenado para toda la serie temporal disponible.
    public function rateDifference(Request $request, $timestamp1 = null, $timestamp2 = null) {
        return response()->json([
            'data' => $this->informationService->getAverageDifference($timestamp1 ?? Carbon::createFromTimestamp(-1), $timestamp2 ?? now()),
        ]);
    }

    // c) Devolver en forma paginada los datos almacenados con o sin filtro de timestamp. (Punto Extras)
    public function list(Request $request) {
        $before = Carbon::parse($request->query('before', now()));
        $after = Carbon::parse($request->query('after', Carbon::createFromTimestamp(-1)));

        return $this->informationService->getListing(compact('before', 'after'));
    }
}

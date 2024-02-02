<?php

namespace App\Http\Controllers;

use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\TradeService\GetDataTrades;

class TestController extends Controller
{
    public function __invoke($ticker, GetDataTrades $getTrades)
    {
        // $figi = $shares->getAll();
        $figi = ShareAttributes::tickerToFigi($ticker);
        $listTrades = $getTrades->getTradesBook($figi);
        //$this->dataTrades = $getTrades->getDataTrades($lictTrades);
        dd($listTrades);
        return $listTrades;
    }
}

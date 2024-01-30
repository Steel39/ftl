<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Shares\SharesController;
use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\TradeService\GetDataTrades;
use App\Services\TradeService\LastHourTrade;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke($ticker,LastHourTrade $LastTrades, GetDataTrades $test2)
    {
       // $test = $testing->getLastHourTrades('BBG008HD3V85');
        $figi = ShareAttributes::tickerToFigi($ticker);
        $trades = $LastTrades->getLastHourTrades($figi);
        $test = $test2->getDataTrades($trades);

        return $test;
    }
}

<?php

namespace App\Http\Controllers;

use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentService\Shares;
use App\Services\TradeService\GetDataTrades;
use App\Services\TradeService\LastHourTrade;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(LastHourTrade $testing, GetDataTrades $testing2)
    {
        $test = $testing->getLastHourTrades('TCSS07661625');
        $test2 = $testing2->getDataTrades($test);
        dd($test2);
    }
}

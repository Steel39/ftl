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
        $test = $testing->getLastHourTrades('BBG008HD3V85');
        $test = $testing2->getDataTrades($test);
        dd($test);
    }
}

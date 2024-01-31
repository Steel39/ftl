<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\Shares\LastTradesController;
use App\Http\Controllers\Shares\SharesController;
use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\TradeService\GetDataTrades;
use App\Services\TradeService\LastHourTrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function __invoke($ticker, GetDataTrades $getTrades)
    {
       // $figi = $shares->getAll();
        $figi = ShareAttributes::tickerToFigi($ticker);
        $listTrades = $getTrades->getListTrades($figi);
        //$this->dataTrades = $getTrades->getDataTrades($lictTrades);
        return $listTrades;
    }
}

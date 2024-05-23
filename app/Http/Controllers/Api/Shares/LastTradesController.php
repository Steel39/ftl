<?php

namespace App\Http\Controllers\Api\Shares;

use App\Http\Controllers\Controller;
use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\TradeService\LastHourTrade;
use App\Services\TradeService\GetDataTrades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LastTradesController extends Controller
{
    public array $dataTrades;

    public function __invoke($ticker, GetDataTrades $getTrades, Shares $shares)
    {
        $figi = ShareAttributes::tickerToIsin($ticker);
        $listTrades = $getTrades->getTradesBook($figi);
        return $listTrades;
    }
}

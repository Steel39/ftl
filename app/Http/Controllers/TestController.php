<?php

namespace App\Http\Controllers;

use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\StreamService\StreamTradesForShares;
use App\Services\TradeService\GetDataTrades;
use App\Services\TradeService\TradeDataHandler;

class TestController extends Controller
{
    public function __invoke(TradeDataHandler $streamTrades)
    {
        $test = $streamTrades->getDataTrades('BBG002GHV6L9');
        dd($test);
    }
}

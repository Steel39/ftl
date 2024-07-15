<?php

namespace App\Http\Controllers;

use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\StreamService\StreamTradesForShares;
use App\Services\TradeService\GetDataTrades;

class TestController extends Controller
{
    public function __invoke(StreamTradesForShares $streamTrades)
    {

        $test = $streamTrades->getStreamTradesShares();
        dd($test);

        

    }
}

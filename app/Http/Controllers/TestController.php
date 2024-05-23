<?php

namespace App\Http\Controllers;

use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\StreamService\StreamTrades;
use App\Services\TradeService\GetDataTrades;

class TestController extends Controller
{
    public function __invoke(StreamTrades $streamTrades)
    {

        $test = $streamTrades->getStream();
        dd($test);

        /* $figi = $shares->getAll();
        $figi = ShareAttributes::tickerToIsin($ticker);
        $listTrades = $getTrades->getTradesBook($figi);
        
        $this->dataTrades = $getTrades->getDataTrades($lictTrades);
        dd($listTrades);
        return $listTrades;
        */

    }
}

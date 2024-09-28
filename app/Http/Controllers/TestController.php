<?php

namespace App\Http\Controllers;

use App\Query\GetStreamTradesQuery;
use App\Query\Handler\GetStreamTradesQueryHandler;
use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\StreamService\StreamTradesForShares;
use App\Services\TradeService\GetDataTrades;
use App\Services\TradeService\TradeDataHandler;
use App\Services\TimeService\Time;

class TestController extends Controller
{
    public function __construct(public readonly Time $query){

    }
    
    public function test()
    {
       $test =  $this->query->getActualTime();
       dd($test);
    }
}
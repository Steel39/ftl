<?php

namespace App\Http\Controllers;

use App\Query\GetStreamTradesQuery;
use App\Query\Handler\GetStreamTradesQueryHandler;
use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\InstrumentService\Shares;
use App\Services\StreamService\StreamTradesForShares;
use App\Services\TradeService\GetDataTrades;
use App\Services\TradeService\TradeDataHandler;

class TestController extends Controller
{
    public function __construct(public readonly TradeDataHandler $query){

    }
    
    public function __invoke()
    {
       return $this->query::getDifferencePrice('BBG004S682Z6');
    }
}
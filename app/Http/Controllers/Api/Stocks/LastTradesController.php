<?php

namespace App\Http\Controllers\Api\Stocks;

use App\Http\Controllers\Controller;
use App\Services\TradeService\LastHourTrade;
use Illuminate\Http\Request;

class LastTradesController extends Controller
{
    /**
     * @var LastHourTrade $trades
     */
    public array $trades;

    /**
     * LastTradesController constructor.
     * @param LastHourTrade $trade
     */
    public function __construct(LastHourTrade $trade)
    {
        $this->trades = $trade;
    }

    /**
     * @param string $ticker
     */
    public function show(string $ticker)
    {

    }
}

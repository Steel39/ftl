<?php

namespace App\Http\Controllers\Api\Stocks;

use App\Http\Controllers\Controller;
use App\Services\InstrumentAttributeService\ShareAttributes;
use App\Services\TradeService\LastHourTrade;
use App\Services\TradeService\GetDataTrades;
use Illuminate\Http\Request;

class LastTradesController extends Controller
{
    private  $trades;
    private $service;
    public array $dataTrades;


    /**
     * LastTradesController constructor.
     * @param LastHourTrade $lastTrade
     */
    public function __construct(LastHourTrade $lastTrade, GetDataTrades $getTrades)
    {
       
        $this->trades = $lastTrade;
        $this->service = $getTrades;
    }

    /**
     * @param string $ticker
     * Принимает тикер инструмента
     * 
     */
    public function getTrades($ticker): array
    {
        $figi = ShareAttributes::tickerToFigi($ticker);
        $repeatedField = $this->trades->getLastHourTrades($figi);
        $this->dataTrades = $this->service->getDataTrades($repeatedField);
        return $this->dataTrades;                     
    }
}

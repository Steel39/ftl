<?php

namespace App\Services\TradeService;
use Tinkoff\Invest\V1\GetLastTradesResponse;
use Tinkoff\Invest\V1\Trade;

class GetDataTrades
{
    public  $dataTrades;

    /**
     * @var GetLastTradesResponse $trades
     * @var Trade $trade
     * Получаем массив данных из массива объектов Trade
     * @return array
     */
    public function getDataTrades(GetLastTradesResponse $trades): ?array {
        $trades=$trades->getTrades();
        foreach($trades as $trade) {
            $this->dataTrades[] = 
            [
                'figi' => $trade->getFigi(),
                'direction' => $trade->getDirection(),
                'price' => $trade->getPrice(),
                'quantity' => $trade->getPrice(),
                'time' => $trade->getTime(),
                'instrument_uid' => $trade->getInstrumentUid(),
            ];
        }
        return $this->dataTrades;
    }
}
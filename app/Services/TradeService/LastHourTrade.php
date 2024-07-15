<?php

namespace App\Services\TradeService;
use App\Services\ConnectService\TinkoffApiConnectService;
use Google\Protobuf\Internal\RepeatedField;
use Tinkoff\Invest\V1\GetLastTradesRequest;
use Tinkoff\Invest\V1\GetLastTradesResponse;
use Tinkoff\Invest\V1\Trade;

class LastHourTrade extends TinkoffApiConnectService
{
    /**
     * Запрос обезличенных сделок за последний час.
     */
    public $tradesRequest;

    public  $lastTrades;

    public function __construct(GetLastTradesRequest $tradesRequests)
    {
        $this->tradesRequest = $tradesRequests;
    }

    /**
     * @return RepeatedField
     * Получаем массив объектов сделок за последний час
     */
    public function getLastHourTrades(string $figi): RepeatedField {
        $this->tradesRequest->setInstrumentId($figi);
        list($response) = $this->getFactoryForClientTinkoffApiService()
            ->marketDataServiceClient
            ->GetLastTrades($this->tradesRequest)
            ->wait();
        $this->lastTrades = $response->getTrades();
        return $this->lastTrades;
    }
}

<?php

namespace App\Services\StreamService;

use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\TradeService\TradeDataHandler;
use App\Services\TradeService\TradeDataHandler\TradeDataHandler as TradeDataHandlerTradeDataHandler;
use Illuminate\Support\Facades\Redis;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\SubscribeTradesRequest;
use Tinkoff\Invest\V1\SubscriptionAction;
use Tinkoff\Invest\V1\TradeInstrument;
use Tinkoff\Invest\V1\TradeSourceType;

final class StreamTradesForShares extends TinkoffApiConnectService
{
    protected InstrumentsRequest $instrumentsRequest;
    protected SubscribeTradesRequest $subscribeTradesRequest;
    private Redis $redis;

    protected array $tradeInstruments = [];
    private TradeDataHandler $tradeDataHandler;
    private MarketDataRequest $marketDataRequest;
    public  $subscription;

    public function __construct(InstrumentsRequest $instrumentsRequest,
                                MarketDataRequest $marketDataRequest,
                                SubscribeTradesRequest $subscribeTradesRequest,
                                Redis $redis, 
                                TradeDataHandler $tradeDataHandler)
    {
        $this->instrumentsRequest = $instrumentsRequest;
        $this->marketDataRequest = $marketDataRequest;
        $this->subscribeTradesRequest = $subscribeTradesRequest;
        $this->redis = $redis;
        $this->tradeDataHandler = $tradeDataHandler;
    }

    public function getStreamTradesShares(): void
    {
        [$response, $status] = $this->getFactoryForClientTinkoffApiService()
            ->instrumentsServiceClient
            ->Shares($this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL))
            ->wait();
        $instruments = $response->getInstruments();
        foreach ($instruments as $instrument) {
            if ($instrument->getCountryOfRisk() === 'RU' && $instrument->getTradingStatus() === 5) {
                $item = (new TradeInstrument())->setFigi($instrument->getFigi());
                $this->tradeInstruments[] = $item;
                echo $instrument->getName() . PHP_EOL;
            }
        }

        if (empty($this->tradeInstruments)) {
            echo "Нет активных инструментов торговли";
            die();
        }
        $this->subscription = $this->marketDataRequest
            ->setSubscribeTradesRequest(($this->subscribeTradesRequest->setTradeType(TradeSourceType::TRADE_SOURCE_ALL))
                ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
                ->setInstruments($this->tradeInstruments)
            );
        $stream = $this->getFactoryForClientTinkoffApiService()->marketDataStreamServiceClient->MarketDataStream();
        $stream->write($this->subscription);
        $this->redis::set('StartStream', date('h:i:s'));
        while($marketDataResponse = $stream->read()) {
            if ($trades = $marketDataResponse->getTrade()) {
                $this->tradeDataHandler->setDataTrade($trades);
            }
        }
        $stream->cancel();
    }
}


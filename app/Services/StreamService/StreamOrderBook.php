<?php

namespace App\Services\StreamService;

use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentService\Shares;
use League\CommonMark\MarkdownConverter;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\OrderBookInstrument;
use Tinkoff\Invest\V1\SubscribeOrderBookRequest;
use Tinkoff\Invest\V1\SubscriptionAction;

class StreamOrderBook extends TinkoffApiConnectService
{
    public  $item;
    public InstrumentsRequest $instrumentsRequest;

    public array $instruments = [];
    protected MarketDataRequest $marketDataRequest;
    private SubscribeOrderBookRequest $subscribeOrderBookRequest;
    protected $subscription;

    public function __construct(InstrumentsRequest $instrumentsRequest, MarketDataRequest $marketDataRequest,
                                SubscribeOrderBookRequest $subscribeOrderBookRequest)
    {
        $this->marketDataRequest = $marketDataRequest;
        $this->subscribeOrderBookRequest = $subscribeOrderBookRequest;
        $this->instrumentsRequest = $instrumentsRequest;
    }

    public function getOrderBookStream()
    {
        list($response) = $this->getFactoryForClientTinkoffApiService()
            ->instrumentsServiceClient
            ->Shares($this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_BASE))
            ->wait();
        $instruments = $response->getInstruments();
        foreach ($instruments as $instrument) {
            if ($instrument->getTradingStatus() === 14 && $instrument->getCountryOfRisk() === 'RU')
                 $this->instruments[] = (new OrderBookInstrument())->setDepth(10)->setFigi($instrument->getFigi());
        }


        $this->subscription = $this->marketDataRequest->setSubscribeOrderBookRequest($this->subscribeOrderBookRequest
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments($this->instruments));
        $stream = $this->getFactoryForClientTinkoffApiService()->marketDataStreamServiceClient->MarketDataStream();
        $stream->write($this->subscription);
        echo "start";
        while ($marketDataResponse = $stream->read()) {
            if ($orderbook = $marketDataResponse->getOrderbook()) {
                echo "Пошла жара";
                $orderbook->getName();
            }
        }
        $stream->cancel();
    }
}

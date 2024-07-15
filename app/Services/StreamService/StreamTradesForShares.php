<?php

namespace App\Services\StreamService;

use App\Interfaces\StreamInterface;
use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentService\Shares;
use Illuminate\Support\Facades\Redis;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\MarketDataResponse;
use Tinkoff\Invest\V1\MarketDataServerSideStreamRequest;
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
    private $tradeInstrument;
    private MarketDataRequest $marketDataRequest;
    public  $subscription;

    public function __construct(InstrumentsRequest $instrumentsRequest,
                                MarketDataRequest $marketDataRequest,
                                TradeInstrument $tradeInstrument,
                                SubscribeTradesRequest $subscribeTradesRequest,
                                Redis $redis)
    {
        $this->instrumentsRequest = $instrumentsRequest;
        $this->marketDataRequest = $marketDataRequest;
        $this->tradeInstrument = $tradeInstrument;
        $this->subscribeTradesRequest = $subscribeTradesRequest;
        $this->redis = $redis;
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
        //dd($this->tradeInstruments);

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
        while($marketDataResponse = $stream->read()) {
            if ($trades = $marketDataResponse->getTrade()) {
                $price =  QuotationHelper::toDecimal($trades->getPrice());
                $this->redis::hSet($trades->getFigi(), $price, $trades->getQuantity());
                $echo = $this->redis::hGet($trades->getFigi(), $price);
                echo $echo;
            }
        }
        $stream->cancel();
    }


}


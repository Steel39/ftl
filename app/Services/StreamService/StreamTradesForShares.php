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

    protected array $tradeInstruments = [];
    private $tradeInstrument;
    private MarketDataRequest $marketDataRequest;
    public  $subscription;

    public function __construct(InstrumentsRequest $instrumentsRequest,
                                MarketDataRequest $marketDataRequest,
                                TradeInstrument $tradeInstrument,
                                SubscribeTradesRequest $subscribeTradesRequest)
    {
        $this->instrumentsRequest = $instrumentsRequest;
        $this->marketDataRequest = $marketDataRequest;
        $this->tradeInstrument = $tradeInstrument;
        $this->subscribeTradesRequest = $subscribeTradesRequest;
    }

    public function getStreamTradesShares(): void
    {
        list($response, $status) = $this->getFactoryForClientTinkoffApiService()
            ->instrumentsServiceClient
            ->Shares($this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL))
            ->wait();
        $instruments = $response->getInstruments();
        foreach ($instruments as $instrument) {
            if ($instrument->getCountryOfRisk() === 'RU' && $instrument->getTradingStatus() === 14) {
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
                echo $trades->getFigi() . PHP_EOL;
            }
        }
        $stream->cancel();
    }


}


<?php

namespace App\Query\Handler;

use App\Infrastructure\TinkoffClient\TinkoffClientAdapter;
use App\Query\GetStreamTradesQuery;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\SubscribeTradesRequest;
use Tinkoff\Invest\V1\TradeInstrument;
use Illuminate\Support\Facades\Log;
use Tinkoff\Invest\V1\MarketDataRequest;
use App\Services\TradeService\TradeDataHandler;
use Tinkoff\Invest\V1\SubscriptionAction;

class GetStreamTradesQueryHandler
{
    private const TRADING_STATUS = 5;
    private const COUNTRY_OF_RISC = 'RU';


    public function __construct(
        private readonly TinkoffClientAdapter $tinkoffClientAdapter,
        private readonly InstrumentsRequest $instrumentsRequest,
        private readonly SubscribeTradesRequest $subscribeTradesRequest,
        private readonly MarketDataRequest $marketDataRequest,
        private readonly TradeDataHandler $tradeDataHanler,
    ) {

    }
    public function __invoke(GetStreamTradesQuery $query)
    {
        $instrumentServiceClient = $this->tinkoffClientAdapter->getClientFactory()->instrumentsServiceClient;
        $allInstruments = $this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        [$instrumentServiceResponse] = $instrumentServiceClient
            ->Shares($allInstruments)
            ->wait();

        $requestedInstruments = $instrumentServiceResponse->getInstruments();
        $instruments = $this->getTradesInstrument($requestedInstruments);

        $subscription = $this->getSubscription($instruments);
        $stream = $this->tinkoffClientAdapter->getClientFactory()->marketDataStreamServiceClient->MarketDataStream();
        $stream->write($subscription);

        Log::info('start Stream of Trades: ' . date('h:i:s'));

        while($mareketDataResponse = $stream->read()){
            if($trade = $mareketDataResponse->getTrade());
                $this->tradeDataHanler->setDataTrade($trade);
        }
        $stream->cancel();
        Log::info('End Stream: '. date('h:i:s'));

    }

    public function getTradesInstrument(mixed $requestedInstruments): array
    {
        $instruments = [];
        foreach ($requestedInstruments as $requestedInstrument) {
            $isTradingStatus = self::TRADING_STATUS === $requestedInstrument->getTradingStatus();
            $isCountryOfRisc = self::COUNTRY_OF_RISC === $requestedInstrument->getCountryOfRisk();
        }
        if ($isTradingStatus && $isCountryOfRisc) {
            $tradeInstrument = new TradeInstrument();
            $tradeInstrument->setFigi($requestedInstrument->getFigi());
            $instruments[] = $tradeInstrument;
        }
        return $instruments;
    }

    /**
     * Summary of getSubscription
     * @param array<int, TradeInstrument> $instruments
     * @return \Tinkoff\Invest\V1\MarketDataRequest
     */
    private function getSubscription(array $instruments): MarketDataRequest
    {
        $subscriptionTradesRequest = $this->subscribeTradesRequest
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments($instruments);

        return $this->marketDataRequest->setSubscribeTradesRequest($subscriptionTradesRequest);
    }
}
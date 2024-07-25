<?php 

namespace App\Qury\Handler;

use App\Infrasructure\TinkoffClient\TinkoffClientAdapter;
use App\Query\GetStreamTradesQuery;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\SubscribeTradesRequest;
use Tinkoff\Invest\V1\TradeInstrument;

class GetStreamTradesQueryHandler
{
    private const TRADING_STATUS = 5;
    private const COUNTRY_OF_RISC = 'RU';


    public function __construct(
        private readonly TinkoffClientAdapter $tinkoffClientAdapter,
        private readonly InstrumentsRequest $instrumentsRequest,
        private readonly SubscribeTradesRequest $subscribeTradesRequest,
    )
    {
        
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

        $subscription = 

    }

    public function getTradesInstrument(mixed $requestedInstruments): array
    {
        $instruments = [];
        foreach($requestedInstruments as $requestedInstrument) {
            $isTradingStatus = self::TRADING_STATUS === $requestedInstrument->getTradingStatus();
            $isCountryOfRisc = self::COUNTRY_OF_RISC === $requestedInstrument->getCountryOfRisk();
        }
        if($isTradingStatus && $isCountryOfRisc) {
            $tradeInstrument = new TradeInstrument();
            $tradeInstrument->setFigi($requestedInstrument->getFigi());
            $instruments[] = $tradeInstrument;
        }
        return $instruments;
    }
    private function getSubscription(array $instruments): MarketDataRequest
    {
        $subscriptionTradesRequest = $this->subscribeTradesRequest
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments($instruments);

        return $this->marketDataRequest->setSubscribeTradesRequest($);
}
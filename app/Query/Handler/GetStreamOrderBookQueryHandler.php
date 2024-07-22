<?php

namespace App\Query\Handler;

use App\Infrasructure\TinkoffClient\TinkoffClientAdapter;
use App\Query\GetStreamOrderBookQuery;
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
use Illuminate\Support\Facades\Log;

class GetStreamOrderBookQueryHandler
{
    private const TRADING_STATUS = 14;
    private const COUNTRY_OF_RISC = 'RU';
    private const INSTRUMENT_DEPTH = 10;

    public function __construct(
        private readonly InstrumentsRequest $instrumentsRequest,
        private readonly MarketDataRequest $marketDataRequest,
        private readonly SubscribeOrderBookRequest $subscribeOrderBookRequest,
        private readonly TinkoffClientAdapter $tinkoffClientAdapter,
    ) {
    }

    public function __invoke(GetStreamOrderBookQuery $query) : void
    {
        $instrumentsServiceClient = $this->tinkoffClientAdapter->getClientFactory()->instrumentsServiceClient;
        $allInstruments = $this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL);

        [$instrumentServiceResponse] = $instrumentsServiceClient
            ->Shares($allInstruments)
            ->wait();

        $requestedInstruments = $instrumentServiceResponse->getInstruments();
        $instruments = $this->getOrderBookInstruments($requestedInstruments);

        $subscription = $this->getSubscription($instruments);

        $stream = $this->tinkoffClientAdapter->getClientFactory()->marketDataStreamServiceClient->MarketDataStream();
        $stream->write($subscription);

        Log::info('start stream order book');

        while ($marketDataResponse = $stream->read()) {
            if ($orderbook = $marketDataResponse->getOrderbook()) {
                Log::info('processing stream order book');

                $orderbook->getName();
            }
        }
        $stream->cancel();

        Log::info('end stream order book');
    }

    private function getOrderBookInstruments(mixed $requestedInstruments): array
    {
        $instruments = [];
        foreach ($requestedInstruments as $requestedInstrument) {
            $isTradingStatus = self::TRADING_STATUS === $requestedInstrument->getTradingStatus();
            $isCountryOfRisc = self::COUNTRY_OF_RISC === $requestedInstrument->getCountryOfRisk();

            if ($isTradingStatus && $isCountryOfRisc) {
                $orderBookInstrument = new OrderBookInstrument();
                $orderBookInstrument
                    ->setDepth(self::INSTRUMENT_DEPTH)
                    ->setFigi($requestedInstrument->getFigi());

                $instruments[] = $orderBookInstrument;
            }
        }

        return $instruments;
    }

    /**
     * @param array<int, OrderBookInstrument> $requestedInstruments
     */
    private function getSubscription(array $instruments): MarketDataRequest
    {
        $subscriptionOrderBookRequest = $this->subscribeOrderBookRequest
            ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
            ->setInstruments($instruments);

        return $this->marketDataRequest->setSubscribeOrderBookRequest($subscriptionOrderBookRequest);
    }
}

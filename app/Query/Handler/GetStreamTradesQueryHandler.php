<?php 

namespace App\Qury\Handler;

use App\Infrasructure\TinkoffClient\TinkoffClientAdapter;
use App\Query\GetStreamTradesQuery;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;

class GetStreamTradesQueryHandler
{
    public function __construct(
        private readonly TinkoffClientAdapter $tinkoffClientAdapter,
        private readonly InstrumentsRequest $instrumentsRequest,

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
        $instruments = $instrumentServiceResponse->getTradeInstruments($requestedInstruments);

    }

    public function getTradesInstrument()
    {
        ;штыекгьут
    }
}
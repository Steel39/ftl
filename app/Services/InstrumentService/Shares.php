<?php

namespace App\Services\InstrumentService;
use App\Services\ConnectService\TinkoffApiConnectService;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\Share;

class Shares extends TinkoffApiConnectService
{
    public array $shares;

    /**
     * @return array возвращает массив объектов Share
     */
    public function getShares(): array
    {
        list($response, $status) = $this->connect()
            ->instrumentsServiceClient
            ->Shares($this->instrument_request->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL))
            ->wait();
        $repeatedField = $response->getInstruments();
        foreach ($repeatedField as $share) {
            $this->shares[] = $share;
        }
        return $this->shares;
    }
}

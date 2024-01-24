<?php

namespace App\Services\InstrumentService;
use App\Services\ConnectService\TinkoffApiConnectService;
use Tinkoff\Invest\V1\Share;
class Shares extends TinkoffApiConnectService
{
    public array $shares;
    public array $moexShares;

    /**
     * @return array
     * возвращает массив объектов Share
     */
    public function getAllShares(): array
    {
        list($response, $status) = $this->connect()
            ->instrumentsServiceClient
            ->Shares($this->getRequest())
            ->wait();
        $repeatedField = $response->getInstruments();
        foreach ($repeatedField as $share) {
            $this->shares[] = $share;
        }
        return $this->shares;
    }

    /**
     * @return array
     * возвращает массив объектов Share,
     * доступных для торговли на MOEX
     * в текущий момент
     */
    public function getOnTraidingMoexShares()
    {
        $shares = $this->getAllShares();
        foreach($shares as $share) {
            if($share->getCountryOfRisk() === 'RU' && $share->getTradingStatus() === 5) {
                $this->moexShares[] = $share;
            }
        }
        return $this->moexShares;
    }
}

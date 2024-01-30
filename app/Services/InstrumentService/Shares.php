<?php

namespace App\Services\InstrumentService;
use App\Services\ConnectService\TinkoffApiConnectService;
use Tinkoff\Invest\V1\Share;
class Shares extends TinkoffApiConnectService
{
    public array $shares;
    public array $moexShares;

    public array $storeShares;

    /**
     * @return array
     * возвращает массив объектов Share
     */
    public function getAll(): array
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
     * @return array Share
     * возвращает массив объектов Share,
     * доступных для торговли на MOEX
     * в текущий момент
     */
    public function getOnTraidingMoex()
    {
        $shares = $this->getAll();
        foreach($shares as $share) {
            if($share->getCountryOfRisk() === 'RU' && $share->getTradingStatus() === 5) {
                $this->moexShares[] = $share;
            }
        }
        return $this->moexShares;
    }

    /**
     * @return array
     * Возвращает массив акций мосбиржи 
     * для записи в базу данных
     */
    function getDataStore() : array {
        $shares = $this->getAll();
        foreach($shares as $share) {
            if($share->getCountryOfRisk() === 'RU') {
                $this->storeShares[] = [
                    'name' => $share->getName(),
                    'ticker' => $share->getTicker(),
                    'figi' => $share->getFigi(),
                    'isin' => $share->getIsin(),
                    'lot' => $share->getLot(),
                    'issue_size' => $share->getIssueSize(),
                    'issue_size_plan' => $share->getIssueSizePlan(),
                ];
            }
        }
        return $this->storeShares;
    }
}

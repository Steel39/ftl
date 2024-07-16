<?php

namespace App\Services\InstrumentService;
use App\Services\ConnectService\TinkoffApiConnectService;
use Google\Protobuf\Internal\RepeatedField;
use Illuminate\Support\Facades\DB;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\Instrument;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\Quotation;
use Tinkoff\Invest\V1\Share;
class Shares extends TinkoffApiConnectService
{
    public array $shares;
    public array $moexSharesActive = [];

    public array $storeShares;

    protected $instrumentsRequest;
    public function __construct(InstrumentsRequest $instrumentsRequest)
    {
        $this->instrumentsRequest = $instrumentsRequest;
    }

    /**
     * @return array
     * возвращает массив объектов Share
     */
    public function getAll(): array
    {
        list($response, $status) = $this->getFactoryForClientTinkoffApiService()
            ->instrumentsServiceClient
            ->Shares($this->instrumentsRequest->setInstrumentStatus(InstrumentStatus::INSTRUMENT_STATUS_ALL))
            ->wait();
        $repeatedField = $response->getInstruments();
        foreach ($repeatedField as $share) {
            $this->shares[] = $share;
        }
        return $this->shares;
    }


    public function getInstrumentsMoexActive(): array
    {
        $instruments = $this->getAll();
        foreach($instruments as $instrument) {
            if($instrument->getCountryOfRisk() === 'RU' && $instrument->getTradingStatus() === 5) {
                
                $this->moexSharesActive[] = $instrument;
            }
        }
        return $this->moexSharesActive;
    }

    public function getInstrumentsDealerActive(): array
    {
        $instruments = $this->getAll();
        foreach($instruments as $instrument) {
            if($instrument->getCountryOfRisk() === 'RU' && $instrument->getTradingStatus() === 14) {
                
                $this->moexSharesActive[] = $instrument;
            }
        }
        return $this->moexSharesActive;
    }


    public function getDataStore() : array
    {
        $shares = $this->getAll();
        foreach($shares as $share) {
            if($share->getCountryOfRisk() === 'RU') {
                $this->storeShares[] = [
                    'name' => $share->getName(),
                    'ticker' => $share->getTicker(),
                    'figi' => $share->getFigi(),
                    'isin' => $share->getIsin(),
                    'uid' => $share->getUid(),
                    'lot' => $share->getLot(),
                    'nominal' => QuotationHelper::toDecimal($share->getNominal()),
                    'issue_size' => $share->getIssueSize(),
                    'issue_size_plan' => $share->getIssueSizePlan(),
                ];
            }
        }
        return $this->storeShares;
    }

    public function setShares() : int
    {
        $data = $this->getDataStore();
        $result = DB::table('shares')->insertOrIgnore($data);
        return $result;
    }
}

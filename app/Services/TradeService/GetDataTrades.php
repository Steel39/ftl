<?php

namespace App\Services\TradeService;

use App\Services\InstrumentAttributeService\ShareAttributes;
use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\Trade;

class GetDataTrades
{

    public  $dataTrades;

    public $listTrades;
    private $lastTrade;
    
    function __construct(LastHourTrade $lastTrade)
    {
        $this->lastTrade = $lastTrade;        
    }


    /**
     * @param string $figi
     * Принимает figi инструмента
     * @return RepeatedField 
     * Возвращает массив данных по сделкам 
     * инструмента последний раз
     */
    public function getListTrades(string $figi): ?array
    {
        $listTrades = $this->lastTrade->getLastHourTrades($figi);
        foreach($listTrades as $trade) {
            $this->dataTrades[] =
            [
                'direction' => $trade->getDirection(),
                'price' => QuotationHelper::toDecimal($trade->getPrice()),
                'quantity' => $trade->getQuantity(),
                'time' => date("h:i:s", $trade->getTime()->getSeconds()),
            ];
        }
        return $this->dataTrades;
    }
}

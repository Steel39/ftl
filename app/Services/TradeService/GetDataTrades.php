<?php

namespace App\Services\TradeService;
use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\Trade;

class GetDataTrades
{
    public  $dataTrades;

    /**
     * @param RepeatedField $trades
     * @var Trade $trade
     * Получаем массив данных из массива объектов Trade
     * @return array
     */
    public function getDataTrades(RepeatedField $trades): ?array
    {
        foreach($trades as $trade) {
            $this->dataTrades[] =
            [
                'figi' => $trade->getFigi(),
                'direction' => $trade->getDirection(),
                'price' => QuotationHelper::toDecimal($trade->getPrice()),
                'quantity' => $trade->getQuantity(),
                'time' => date($trade->getTime()->getSeconds()),
                'instrument_uid' => $trade->getInstrumentUid(),
            ];
        }
        return $this->dataTrades;
    }
}

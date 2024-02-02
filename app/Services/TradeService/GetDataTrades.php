<?php

namespace App\Services\TradeService;

use App\Services\InstrumentAttributeService\ShareAttributes;
use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\Trade;

class GetDataTrades
{
    public array $listTrades;
    public array $buylistTrades = [];
    public array $selllistTrades = [];
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
     * инструмента за последний час
     */
    public function getListTrades(string $figi): ?array
    {
        $dataTrades = $this->lastTrade->getLastHourTrades($figi);
        foreach ($dataTrades as $trade) {
            if ($trade->getDirection() === 1) {
                $this->buylistTrades[] =
                    [
                        'price' => QuotationHelper::toDecimal($trade->getPrice()),
                        'quantity' => $trade->getQuantity(),
                        'time' => date('H:i:s', $trade->getTime()->getSeconds()),
                    ];
            } elseif ($trade->getDirection() === 2) {
                $this->selllistTrades[] =
                    [
                        'price' => QuotationHelper::toDecimal($trade->getPrice()),
                        'quantity' => $trade->getQuantity(),
                        'time' => date('H:i:s', $trade->getTime()->getSeconds()),
                    ];
            }
        }
        return $this->listTrades[] = [ 'buy' => $this->buylistTrades, 'sell' => $this->selllistTrades];       
    }

    public function getTradesBook($figi) 
    {
        $data = $this->lastTrade->getLastHourTrades($figi);
        foreach ($data as $trade) {
            $price = QuotationHelper::toDecimal($trade->getPrice());
            $count = $trade->getQuantity();
            if($trade->getDirection() === 1) {
                if(array_key_exists(("$price"), $this->buylistTrades)) {
                    $count = $this->buylistTrades["$price"] + $count;
                    $this->buylistTrades["$price"] = $count;
                } else {
                    $this->buylistTrades["$price" ] = $count;
                }
            }
            if($trade->getDirection() === 2) {
                if(array_key_exists(("$price"), $this->selllistTrades)) {
                    $count = $this->selllistTrades["$price"] + $count;
                    $this->selllistTrades["$price"] = $count;
                } else {
                    $this->selllistTrades["$price"] = $count;
                }
            }
        }
        ksort($this->buylistTrades);
        ksort($this->selllistTrades);
        return $this->listTrades[] =
        [
            'buy' => $this->buylistTrades,
            'sell' => $this->selllistTrades
        ];
    }
}

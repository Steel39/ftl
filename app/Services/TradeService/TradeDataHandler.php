<?php

namespace App\Services\TradeService;

use App\Services\FrontPlaceService\Color;
use App\Services\InstrumentAttributeService\ShareAttributes;
use Illuminate\Support\Facades\Redis;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Tinkoff\Invest\V1\Trade;
use Illuminate\Support\Facades\DB;

class TradeDataHandler
{
    private Redis $redis;
    private Color $colorService;
    public array $tradeVolumes;

    public function __construct(Redis $redis, Color $colorService)
    {
        $this->redis = $redis;   
        $this->colorService = $colorService;             
    }

    /**
     * @var Trade $trade
     */
    public function setDataTrade(Trade $trade): void
    {
        if($trade->getDirection() === 1) {
            $figi = $trade->getFigi();
            $price = QuotationHelper::toDecimal($trade->getPrice());
            $hashCount = $this->redis::hGet("BUY:$figi", $price);
            $count = $trade->getQuantity() + $hashCount;
            $this->redis::hSet("BUY:$figi", $price, $count);        
        }
        if($trade->getDirection() === 2) {
            $figi = $trade->getFigi();
            $price = QuotationHelper::toDecimal($trade->getPrice());
            $hashCount = $this->redis::hGet("SELL:$figi", $price);
            $count = $trade->getQuantity() + $hashCount;
            $this->redis::hSet("SELL:$figi", $price, $count);        
        }
    }

    public function getDataTrade($figi): array
    {
        $trades['name'] = ShareAttributes::figiToName($figi);
        $trades['ticker'] = ShareAttributes::figiToTicker($figi);
        $trades['buy'] = $this->redis::hGetAll("BUY:$figi");
        $trades['sell'] = $this->redis::hGetAll("SELL:$figi");
        $trades['allBuy'] = array_sum($trades['buy']);
        $trades['allSell'] = array_sum($trades['sell']);
        $trades['color'] = $this->colorService->setColorSharesLight($trades['allBuy'], $trades['allSell']);
        return $trades;
    }

    public function getTradeVolumes(): array
    {
        $keys = DB::table('shares')->select('figi', 'ticker')->get()->toArray();
        foreach($keys as $key) {
            $this->tradeVolumes[$key->figi] = $this->getDataTrade($key->figi);
        }
        return $this->tradeVolumes;
    }
}
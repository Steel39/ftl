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
    public function __construct(
        private readonly Redis $redis,
        private readonly Color $color)
    {

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
            $this->redis::hMSet("BUY:$figi", $price, $count);
        }
        if($trade->getDirection() === 2) {
            $figi = $trade->getFigi();
            $price = QuotationHelper::toDecimal($trade->getPrice());
            $hashCount = $this->redis::hGet("SELL:$figi", $price);
            $count = $trade->getQuantity() + $hashCount;
            $this->redis::hSet("SELL:$figi", $price, $count);
        }
        if(empty($this->redis::get("startPrice:$figi"))){
            $this->redis::set("startPrice:$figi", $price);
        }
        $this->redis::set("endPrice:$figi", $price);

    }

    public function getDataTrade(string $figi): array
    {
        $trades['name'] = ShareAttributes::figiToName($figi);
        $trades['ticker'] = ShareAttributes::figiToTicker($figi);
        $buy = $this->redis::hGetAll("BUY:$figi");
        $sell = $this->redis::hGetAll("SELL:$figi");
        $trades['allBuy'] = array_sum($buy);
        $trades['allSell'] = array_sum($sell);
        $trades['color'] = $this->color->setColorSharesLight($trades['allBuy'], $trades['allSell']);
        $trade['startPrice'] = $this->redis::get("startPrice:$figi");
        return $trades;
    }

    public function getTradeVolumes(): array
    {
        $tradeVolumes = [];
        $keys = DB::table('shares')->select('figi', 'ticker')->get()->toArray();
        foreach($keys as $key) {
            $tradeVolumes[$key->figi] = $this->getDataTrade($key->figi);
        }
        return $tradeVolumes;
    }

    public static function getDifferencePrice($figi): float
    {
        $startPrice = Redis::get("startPrice:$figi");
        $endPrice = Redis::get("endPrice:$figi");
        $diff = ($endPrice - $startPrice)/100*$startPrice;
        return $diff;
    }
}

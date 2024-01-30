<?php

namespace App\Services\InstrumentAttributeService;

use App\Models\Shares;

class ShareAttributes 
{
    public static  $shares;

    public function __construct(Shares $shares) 
    {
        $this->shares = $shares;
    }     

    public static function tickerToFigi(string $ticker): string
    {
        $figi = self::$shares->where('ticker', $ticker)->pluck('figi')->first();
        return $figi;
    }
}
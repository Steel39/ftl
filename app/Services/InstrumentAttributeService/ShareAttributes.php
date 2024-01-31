<?php

namespace App\Services\InstrumentAttributeService;

use App\Models\Shares;
use Illuminate\Support\Facades\DB;

class ShareAttributes 
{
    public static  $shares;   

    public static function tickerToFigi(string $ticker): string
    {
        $figi = DB::table('shares')->where('ticker', $ticker)->value('figi');
        return $figi;
    }
}
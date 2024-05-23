<?php

namespace App\Services\InstrumentAttributeService;


use Illuminate\Support\Facades\DB;

class ShareAttributes 
{
    public static function tickerToIsin(string $ticker): string
    {
        $isin = DB::table('shares')->where('ticker', $ticker)->value('uid');
        return $isin;
    }
}
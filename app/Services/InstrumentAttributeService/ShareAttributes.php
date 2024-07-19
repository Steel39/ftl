<?php

namespace App\Services\InstrumentAttributeService;


use Illuminate\Support\Facades\DB;

final class ShareAttributes 
{
    public static function tickerToIsin(string $ticker): string
    {
        $isin = DB::table('shares')->where('ticker', $ticker)->value('uid');
        return $isin;
    }

    public static function figiToName(string $figi): string
    {
        $name = DB::table('shares')->where('figi', $figi)->value('name');
        return $name;
    }

    
}
<?php

namespace App\Services\FrontPlaceService;

class Color
{
    public function setColorSharesLight(int $buy, $sell) : string
    {
        $lightColor = '';
        if($buy > $sell) {
            $lightColor = 'green';
        }
        if ($buy < $sell) {
            $lightColor = 'red';
        }
        if($buy == 0 && $sell == 0) {
            $lightColor = 'zinc';
        }
        return $lightColor;
    }
    public function setColorDifferencePrice(float $diff): string
    {
        $differenceColor = 'black';

        if($diff > 0){
            $differenceColor = 'green';
        }
        if($diff < 0) {
            $differenceColor = 'red';
        }
        return $differenceColor;
    }
}

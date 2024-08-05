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

    public function setIntenseLight(int $buy, $sell)
    {
        $intense = 100;

        if($buy>$sell*2) {
            $intense = 200;
        }
        if($buy>$sell*3) {
            $intense = 300;
        }
        if($buy>$sell*4) {
            $intense = 400;
        }
        if($buy>$sell*5) {
            $intense = 500;
        }
        if($buy>$sell*6) {
            $intense = 600;
        }
        if($sell>$buy*2) {
            $intense = 200;
        }
        if($sell>$buy*3) {
            $intense = 300;
        }
        if($sell>$buy*4) {
            $intense = 400;
        }
        if($sell>$buy*5) {
            $intense = 500;
        }
        if($sell>$buy*6) {
            $intense = 600;
        }

        return $intense;
        
    }
}

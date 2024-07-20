<?php 

namespace App\Services\FrontPlaceService;

class Color 
{
    public string $lightColor;

    public function setColorSharesLight(int $buy, $sell) : string
    {
        if($buy > $sell) {
            $this->lightColor = 'green';
        }
        if ($buy < $sell) {
            $this->lightColor = 'red';
        }
        if($buy == 0 || $sell == 0) {
            $this->lightColor = 'gray';
        }
        return $this->lightColor;
    }
}
<?php

namespace App\Services\TimeService;
use Illuminate\Support\Carbon;

class Time 
{
    public function __construct(
        private readonly Carbon $carbon,
    )
    {

    }

    public function getActualTime() {
        return new Carbon();
    }
}
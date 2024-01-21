<?php

namespace App\Http\Controllers;

use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentService\Shares;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Shares $shares)
    {
        $test = $shares->getShares();
        dd($test);

    }
}

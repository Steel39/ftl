<?php

namespace App\Http\Controllers\Api\Stocks;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function __invoke() {
        $data = [
            'ticker' => 'GAZP',
            'price' => 200
        ];
        return $data;
    }
}

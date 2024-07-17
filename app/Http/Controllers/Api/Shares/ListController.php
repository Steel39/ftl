<?php

namespace App\Http\Controllers\Api\Shares;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListController extends Controller
{
    public function __invoke()
    {
        $data = DB::table('shares')->get()->toJson();
        return $data;
    }
}

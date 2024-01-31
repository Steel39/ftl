<?php

use App\Http\Controllers\Api\Shares\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('stocks', ListController::class);
//Route::get('test', \App\Http\Controllers\TestController::class);
Route::get('get_trades/{ticker}', App\Http\Controllers\Api\Shares\LastTradesController::class);
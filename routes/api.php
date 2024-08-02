<?php

use App\Http\Controllers\Shares\SharesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('setStocks', [SharesController::class, 'store']);
Route::get('showStocks', [SharesController::class, 'show']);
Route::get('getStream', [SharesController::class, 'getStream']);
Route::delete('destroy', [SharesController::class, 'destroy']);
Route::get('setActive', [SharesController::class, 'setActive']);
Route::get('getTradesData', [SharesController::class, 'getTradesData']);
Route::get('destroyHashMemory', [SharesController::class, 'destroyHashMemory']);
//Route::get('test', \App\Http\Controllers\TestController::class);
Route::get('get_trades/{ticker}', App\Http\Controllers\Api\Shares\LastTradesController::class);
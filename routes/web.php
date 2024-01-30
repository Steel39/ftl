<?php

use App\Http\Controllers\Api\Stocks\LastTradesController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('app');
})->where('all', '.*');

Route::get('/test/{ticker}', [LastTradesController::class, 'getTrades']);

<?php

namespace App\Providers;

use App\Services\ConnectService\TinkoffApiConnectService;
use Illuminate\Support\ServiceProvider;
use Tinkoff\Invest\V1\InstrumentRequest;
use Tinkoff\Invest\V1\InstrumentsRequest;

class ConnectTinkoffApiProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

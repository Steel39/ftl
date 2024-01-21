<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Tinkoff\Invest\V1\InstrumentsRequest;

class TinkoffInstrumentProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(InstrumentsRequest::class, function ($app){
            return new InstrumentsRequest;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Infrastructure\TinkoffClient;

use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;

final class TinkoffClientAdapter
{
    public function getClientFactory(): TinkoffClientsFactory
    {
        return TinkoffClientsFactory::create(config('services.tinkoff.token'));
    }

}
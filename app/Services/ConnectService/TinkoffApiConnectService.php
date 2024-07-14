<?php

namespace App\Services\ConnectService;

use App\Interfaces\ConnectInterface;
use Google\Protobuf\Internal\RepeatedField;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;

abstract class TinkoffApiConnectService
{
    /**
     * @var object $factory Экземпляр фабрики для получения клиентов
     */
    protected TinkoffClientsFactory $factory;

    protected function getFactoryForClientTinkoffApiService(): TinkoffClientsFactory
    {
        $this->factory = TinkoffClientsFactory::create(config('services.tinkoff.token'));
        return $this->factory;
    }

}

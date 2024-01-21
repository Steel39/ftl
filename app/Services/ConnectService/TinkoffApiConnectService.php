<?php

namespace App\Services\ConnectService;

use App\Interfaces\ConnectInterface;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;

class TinkoffApiConnectService implements ConnectInterface
{
    /**
     * @var string $token Токен Аутентификации
     */
    private string $token;

    /**
     * @var object $factory Экземпляр фабрики для получения клиентов
     */
    public TinkoffClientsFactory $factory;

    /**
     * @var InstrumentsRequest $request Запрос инструментов
     */
    public InstrumentsRequest $instrument_request;

    public function __construct(InstrumentsRequest $request)
    {
        $this->instrument_request = $request;
    }


    /**
     * @return TinkoffClientsFactory Возвращает Экземпляр фабрики для клиентов доступа к сервисам Tinkoff
     */
    public function connect(): TinkoffClientsFactory
    {
        $this->factory = TinkoffClientsFactory::create(config('services.tinkoff.token'));
        return $this->factory;
    }
}

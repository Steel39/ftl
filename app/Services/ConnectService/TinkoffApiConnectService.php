<?php

namespace App\Services\ConnectService;

use App\Interfaces\ConnectInterface;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;

abstract class TinkoffApiConnectService implements ConnectInterface
{
    /**
     * @var object $factory Экземпляр фабрики для получения клиентов
     */
    protected TinkoffClientsFactory $factory;

    /**
     * @var InstrumentsRequest $request Запрос инструментов
     */

    /**
     *@var $request
     *Запрос к сервисам
     */ 
    protected InstrumentsRequest $request;
    
    /**
     * @var $status
     * Статус Инструментов для запроса 
     */
    protected InstrumentStatus $status;

    
    public function __construct(InstrumentsRequest $request, InstrumentStatus $status)
    {
        $this->request = $request;
        $this->status = $status;
    }

    /**
     * @return TinkoffClientsFactory
     * Возвращает Экземпляр фабрики для клиентов доступа к сервисам Tinkoff
     */
    public function connect(): TinkoffClientsFactory
    {
        $this->factory = TinkoffClientsFactory::create(config('services.tinkoff.token'));
        return $this->factory;
    }

    /**
     * @return InstrumentsRequest 
     * Получаем запрос на подключение к сервисам Tinkoff
     */
    public function getRequest() 
    {
        $this->request->setInstrumentStatus($this->status::INSTRUMENT_STATUS_ALL);
        return $this->request;
    }
}

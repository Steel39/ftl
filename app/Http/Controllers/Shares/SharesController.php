<?php

namespace App\Http\Controllers\Shares;

use App\Services\InstrumentService\Shares;
use App\Http\Controllers\Controller;
use App\Services\TradeService\TradeDataHandler;
use Illuminate\Support\Facades\DB;

class SharesController extends Controller
{
    private $service;
    private $tradeDataHandler;

    public $data;

    public function __construct(Shares $service, TradeDataHandler $tradeDataHandler)
    {
        $this->service = $service;
        $this->tradeDataHandler = $tradeDataHandler;

    }

    public function show() : array
    {
        $this->data = DB::table('shares')->get()->toArray();
        return $this->data;
    }

    public function store() : string 
    {
        $data = $this->service->getAllInstruments();
        $this->service->setShares($data);
        return 'Акции успешно загружены с сервера Т в базу данных';
    }

    public function destroy() : string 
    {
        DB::table('shares')->delete();
        return 'Акции удалены из базы данных';
    }

    public function setActive(): string
    {
        $data = $this->service->getInstrumentsMoexActive();
        $this->service->setShares($data);
        return "Загружены торгующиеся акции";
    }
    public function getTradesData()
    {
        return $this->tradeDataHandler->getTradeVolumes();        
    }
}

<?php

namespace App\Http\Controllers\Shares;

use App\Services\InstrumentService\Shares;
use App\Http\Controllers\Controller;
use App\Services\TradeService\TradeDataHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Services\StreamService\StreamTradesForShares;

class SharesController extends Controller
{
    public $data;

    public function __construct(private readonly Shares $service,
                                private readonly TradeDataHandler $tradeDataHandler,
                                private readonly StreamTradesForShares $stream)
    {

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
    public function getTradesData(): ?array
    {
        $data['trades'] = $this->tradeDataHandler->getTradeVolumes(); 
        $data['time'] = $this->tradeDataHandler->getTimeStartStream();
        $data['lastTimeTrade'] = $this->tradeDataHandler->getTimeLastTrade();
        return $data;
    }

    public function destroyHashMemory(): string
    {
        $status = 'Статус: неопределено';
        $flushall = Redis::flushall();
        if($flushall == 1) {
            $status = 'Очищено';
        }
        if($flushall == 0) {
            $status = 'Что-то пошло не так';
        }
        return $status;
    }

    public function getStream() : string
    {
        return $this->stream->getStreamTradesShares();
    }
}

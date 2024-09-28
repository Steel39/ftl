<?php 

namespace App\Http\Controllers\Shares;
use App\Services\TradeService\TradeDataHandler;
use Inertia\Inertia;

class GuestSharesController
{
    public function __construct(
        private readonly TradeDataHandler $tradeDataHandler,
    )
    {

    }

    public function __invoke()
    {
        $data = $this->tradeDataHandler->getTradeVolumes();
        return Inertia::render('GuestShares', $data);
    }
}
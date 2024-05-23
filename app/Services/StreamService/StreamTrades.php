<?php

namespace App\Services\StreamService;

use App\Interfaces\StreamInterface;
use App\Services\ConnectService\TinkoffApiConnectService;
use App\Services\InstrumentService\Shares;
use Metaseller\TinkoffInvestApi2\helpers\QuotationHelper;
use Metaseller\TinkoffInvestApi2\TinkoffClientsFactory;
use Tinkoff\Invest\V1\InstrumentsRequest;
use Tinkoff\Invest\V1\InstrumentStatus;
use Tinkoff\Invest\V1\MarketDataRequest;
use Tinkoff\Invest\V1\SubscribeTradesRequest;
use Tinkoff\Invest\V1\SubscriptionAction;
use Tinkoff\Invest\V1\TradeInstrument;

class StreamTrades extends TinkoffApiConnectService 
{


    public $meta_instruments = [];
    
    public InstrumentsRequest $request;

    public MarketDataRequest $marketDataRequest;

    public TradeInstrument $tradeInstrument;

    public SubscribeTradesRequest $subscribeTradesRequest;

    protected $subscription;
    public $shares;
 
    public function __construct(Shares $shares,
                                TradeInstrument $tradeInstrument,
                                InstrumentsRequest $instrumentsRequest,
                                MarketDataRequest $marketDataRequest,
                                SubscribeTradesRequest $subscribeTradesRequest)
    {
        $this->shares = $shares->getOnTraidingMoex();
        $this->tradeInstrument = $tradeInstrument;
        $this->request = $instrumentsRequest;
        $this->marketDataRequest = $marketDataRequest;
        $this->subscribeTradesRequest = $subscribeTradesRequest;
    }
    public function getStream()
    {
        //dd($this->shares);
        foreach($this->shares as $share) {
            $item = $this->tradeInstrument->setFigi($share->getFigi());
            array_push($this->meta_instruments, $item);
        }
        $this->subscription = $this->marketDataRequest
        ->setSubscribeTradesRequest(
            ($this->subscribeTradesRequest)
                ->setSubscriptionAction(SubscriptionAction::SUBSCRIPTION_ACTION_SUBSCRIBE)
                ->setInstruments($this->meta_instruments)
        );
        $stream = $this->connect()->marketDataStreamServiceClient->MarketDataStream();
        $stream->write($this->subscription);
        while($market_data_response = $stream->read()) {
            if($trades = $market_data_response->getTrade()) {
                $trade_dir = $trades->getDirection();
                $trade_uid = $trades->getUid();
                $trade_count = $trades->getQuantity();
                $trade_price = QuotationHelper::toDecimal($trades->getPrice());
                
            }
        }

        dd($stream);        
    }

}
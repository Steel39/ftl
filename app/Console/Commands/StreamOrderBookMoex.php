<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StreamService\StreamOrderBook;

class StreamOrderBookMoex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stream:orderbook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Стакан заявок';

    /**
     * Execute the console command.
     */
    public function handle(StreamOrderBook $streamOrderBook)
    {
        $streamOrderBook->getOrderBookStream();
    }
}

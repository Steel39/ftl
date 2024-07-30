<?php

namespace App\Console\Commands;

use App\Services\StreamService\StreamTradesForShares;
use Illuminate\Console\Command;

class StreamTradesSharesMoex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stream:shares';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stream data trades on MOEX';

    /**
     * Execute the console command.
     */
    public function handle(zz $streamTrades): void
    {
        $streamTrades->getStreamTradesShares();
    }
}

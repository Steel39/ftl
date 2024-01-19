<?php 

namespace App\Services\InstrumentService;
use App\Interfaces\ConnectInterface;

class Shares implements ConnectInterface
{
    private string $token;

    private function getToken(): string {
        $this->token = config('');
        return $this->token;
    } 

    private function connect() {
        
    }
}
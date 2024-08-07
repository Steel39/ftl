<?php 

namespace App\Http\Controllers;
use Inertia\Inertia;

class LastTradeController 
{
    function __invoke()  
    {
        return Inertia::render('LastTrade');    
    }
}
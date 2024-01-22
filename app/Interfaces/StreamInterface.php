<?php

namespace App\Interfaces;

interface StreamInterface
{
    public function connectStream();

    public function readStream();
    
    public function getDataStream();

}

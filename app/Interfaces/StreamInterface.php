<?php

namespace App\Interfaces;
/**
 * Интерфейс для соединения со стриминговыми сервисами tinkoff
 */
interface StreamInterface
{
    public function connectStream();

    public function readStream();
    
    public function getDataStream();

}

<?php

namespace App\Interfaces;
/**
 * Интерфейс для работы со стриминговыми сервисами tinkoff
 */
interface StreamInterface
{
    public function connectStream();

    public function readStream();
    
    public function getDataStream();

}

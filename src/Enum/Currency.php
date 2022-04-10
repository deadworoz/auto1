<?php

namespace App\Enum;

enum Currency: string
{
    case SVU = 'SVU';    

    public function getCode(): string
    {
        return $this->value;
    }
}

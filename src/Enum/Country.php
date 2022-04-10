<?php

namespace App\Enum;

enum Country: string
{
    case GERMANY = 'DE';
    case SPAIN = 'ES';
    case PORTUGAL = 'PT';
    case NETHERLANDS = 'NL';
    case BELGIUM = 'BE';
    case IRELAND = 'IE';

    public function getCode(): string
    {
        return $this->value;
    }
}

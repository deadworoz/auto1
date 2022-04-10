<?php

namespace App\Enum;

use App\ArgumentResolver\ResolvableEnumInterface;

enum Country: string implements ResolvableEnumInterface
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

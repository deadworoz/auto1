<?php

namespace App\Enum;

enum CompanySize: string
{
    case SMALL = '10-50';
    case MIDDLE = '50-100';
    case BIG = '100-500';
    case LARGE = '1000-5000';

    public function getTitle(): string
    {
        return $this->value;
    }
}

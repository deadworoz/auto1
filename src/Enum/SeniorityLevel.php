<?php

namespace App\Enum;

enum SeniorityLevel: string
{
    case JUNIOR = 'Junior';
    case MIDDLE = 'Middle';
    case SENIOR = 'Senior';
    case TECH_MANAGMENT = 'Tech management';

    public function getTitle(): string
    {
        return $this->value;
    }
}

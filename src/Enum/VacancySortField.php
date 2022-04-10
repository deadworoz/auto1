<?php

namespace App\Enum;

use App\ArgumentResolver\ResolvableEnumInterface;

enum VacancySortField: string implements ResolvableEnumInterface
{
    case SALARY = 'salary';
    case SENIORITY_LEVEL = 'seniorityLevel';

    public function getFieldName(): string
    {
        return $this->value;
    }
}

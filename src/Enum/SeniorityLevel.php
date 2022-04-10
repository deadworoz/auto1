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

    public function equalOrNext(SeniorityLevel $other): bool
    {
        $diff = $this->toInt() - $other->toInt();
        return (0 <= $diff) && ($diff <= 1);
    }

    private function toInt(): int
    {
        return match($this) {
            SeniorityLevel::JUNIOR => 0,
            SeniorityLevel::MIDDLE => 1,
            SeniorityLevel::SENIOR => 2,
            SeniorityLevel::TECH_MANAGMENT => 3,
        };
    }
}

<?php

namespace App\Enum;

enum SeniorityLevel: string
{
    case JUNIOR = 'Junior';
    case MIDDLE = 'Middle';
    case SENIOR = 'Senior';
    case TECH_MANAGMENT = 'Tech management';

    public static function choices(): array
    {
        $choices = [];
        foreach (self::cases() as $case) {
            $choices[] = $case->value;
        }

        return $choices;
    }

    /**
     * @return string[]
     */
    public static function orderedValues(): array
    {
        $cases = self::cases();
        usort($cases, self::getComparator());

        return array_map(static function (SeniorityLevel $level): string {
            return $level->value;
        }, $cases);
    }

    public static function getComparator(): callable
    {
        return static function (SeniorityLevel $a, SeniorityLevel $b): int {
            return $a->toInt() - $b->toInt();
        };
    }

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

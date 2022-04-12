<?php

declare(strict_types=1);

namespace App\DTO;

final class VacancyListDTO implements \JsonSerializable
{
    private array $vacancies;

    public function __construct(array $vacancies)
    {
        $this->vacancies = $vacancies;
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->vacancies,
        ];
    }
}

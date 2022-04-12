<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Vacancy;

final class VacancyListDTO implements \JsonSerializable
{
    /** @var Vacancy[] */
    public array $items;

    public function __construct(array $vacancies)
    {
        $this->items = $vacancies;
    }

    public function jsonSerialize(): array
    {
        return [
            'items' => $this->items,
        ];
    }
}

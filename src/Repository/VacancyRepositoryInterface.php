<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vacancy;
use App\Enum\Country;

interface VacancyRepositoryInterface
{
    public function findById(int $id): ?Vacancy;

    /**
     * @return Vacancy[]
     */
    public function findByCountry(Country $country): array;
}

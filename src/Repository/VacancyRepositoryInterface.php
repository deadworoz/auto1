<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vacancy;
use App\Enum\City;
use App\Enum\Country;

interface VacancyRepositoryInterface
{
    public function findById(int $id): ?Vacancy;

    /**
     * @return Vacancy[]
     */
    public function findByCountry(Country $country): array;

    /**
     * @return Vacancy[]
     */
    public function findByCity(City $city): array;

    /**
     * @return Vacancy[]
     */
    public function findByCriteria(callable $criteria): array;
}

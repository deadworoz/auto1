<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vacancy;

interface VacancyRepositoryInterface
{
    public function findById(int $id): ?Vacancy;
}

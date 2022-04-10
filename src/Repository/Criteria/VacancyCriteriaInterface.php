<?php

declare(strict_types=1);

namespace App\Repository\Criteria;

interface VacancyCriteriaInterface
{
    public function __invoke(array $vacancyRow): bool;
}

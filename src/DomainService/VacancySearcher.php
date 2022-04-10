<?php

declare(strict_types=1);

namespace App\DomainService;

use App\Enum\City;
use App\Enum\Country;
use App\Enum\VacancySortField;
use App\Repository\VacancyRepositoryInterface;

class VacancySearcher
{
    private VacancyRepositoryInterface $vacancyRepository;
    
    public function __construct(VacancyRepositoryInterface $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    public function findByCountry(Country $country, VacancySortField $sortBy): array
    {
        $vacancies = $this->vacancyRepository->findByCountry($country);
        return $vacancies;
    }

    public function findByCity(City $city, VacancySortField $sortBy): array
    {
        $vacancies = $this->vacancyRepository->findByCity($city);
        return $vacancies;
    }
}

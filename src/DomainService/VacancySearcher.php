<?php

declare(strict_types=1);

namespace App\DomainService;

use App\DTO\BestFitRequestDTO;
use App\Entity\Vacancy;
use App\Enum\City;
use App\Enum\Country;
use App\Enum\VacancySortField;
use App\Repository\VacancyRepositoryInterface;
use App\Repository\Criteria\BestFitCriteria;

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

    public function findBestFit(BestFitRequestDTO $dto): ?Vacancy
    {
        $crtiteria = new BestFitCriteria(
            $dto->getSkills(),
            $dto->getSeniorityLevel(),
            $dto->isCandidateWantsToLieLowInBruges(),
        );
        
        $shortList = $this->vacancyRepository->findByCriteria($crtiteria);   

        return count($shortList) > 0 ? $shortList[0] : null;
    }
}

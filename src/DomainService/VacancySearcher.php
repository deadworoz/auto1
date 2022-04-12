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
        usort($vacancies, Vacancy::getComparator($sortBy));

        return $vacancies;
    }

    public function findByCity(City $city, VacancySortField $sortBy): array
    {
        $vacancies = $this->vacancyRepository->findByCity($city);
        usort($vacancies, Vacancy::getComparator($sortBy));

        return $vacancies;
    }

    public function findBestFit(BestFitRequestDTO $dto): ?Vacancy
    {
        $crtiteria = new BestFitCriteria(
            $dto->getSkillList(),
            $dto->getLevel(),
            $dto->isCandidateWantsToLieLowInBruges(),
        );

        $vacancies = $this->vacancyRepository->findByCriteria($crtiteria);
        usort($vacancies, Vacancy::getComparator(VacancySortField::SALARY));
        $vacancies = array_reverse($vacancies);

        return count($vacancies) > 0 ? $vacancies[0] : null;
    }
}

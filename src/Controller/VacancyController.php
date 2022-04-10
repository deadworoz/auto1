<?php

declare(strict_types=1);

namespace App\Controller;

use App\DomainService\VacancySearcher;
use App\DTO\VacancyListRequest;
use App\Enum\Country;
use App\Enum\VacancySortField;
use App\Repository\VacancyRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vacancy', name: 'vacancy_')]
class VacancyController extends AbstractBaseController
{
    private VacancyRepositoryInterface $vacancyRepository;
    
    public function __construct(VacancyRepositoryInterface $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    #[Route('/{id}', name:'by_id')]
    public function getById(int $id): Response
    {
        $vacancy = $this->vacancyRepository->findById($id);
        if ($vacancy === null) {
            throw $this->createNotFoundException('Vacancy not found');
        }
        
        return $this->json($vacancy);
    }

    #[Route('/by-country/{countryCode}', name:'by_country')]
    public function getByCountry(Country $countryCode, ?VacancySortField $sortBy, VacancySearcher $searcher): Response
    {
        $vacancies = $searcher->findByCountry($countryCode, $sortBy ?? VacancySortField::SALARY);
        return $this->json(['items' => $vacancies]);
    }

    #[Route('/the-best', name:'get_the_best', priority: 1)]
    public function getBest(): Response
    {
        $vacancy = $this->vacancyRepository->findById(1);
        if ($vacancy === null) {
            throw $this->createNotFoundException('Vacancy not found');
        }
        return $this->json($vacancy);
    }
}

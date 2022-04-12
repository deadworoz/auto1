<?php

declare(strict_types=1);

namespace App\Controller;

use App\DomainService\VacancySearcher;
use App\DTO\BestFitRequestDTO;
use App\DTO\BestFitResponseDTO;
use App\DTO\VacancyListDTO;
use App\Enum\City;
use App\Enum\Country;
use App\Enum\VacancySortField;
use App\Entity\Vacancy;
use App\Repository\VacancyRepositoryInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/vacancy', name: 'vacancy_', format: 'json')]
class VacancyController extends AbstractBaseController
{
    private VacancyRepositoryInterface $vacancyRepository;

    public function __construct(VacancyRepositoryInterface $vacancyRepository)
    {
        $this->vacancyRepository = $vacancyRepository;
    }

    #[Route('/{id}', name:'by_id', methods: ['GET'], requirements: ['id' => '\d+'])]
    /**
     * @OA\Get(
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=Vacancy::class)
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="Not found"
     *   )
     * )
     */
    public function getById(int $id): Response
    {
        $vacancy = $this->vacancyRepository->findById($id);
        if ($vacancy === null) {
            throw $this->createNotFoundException('Vacancy not found');
        }

        return $this->json($vacancy);
    }

    #[Route('/by-country/{country}', name:'by_country', methods: ['GET'], requirements: ['country' => '\w\w'])]
    public function getByCountry(Country $country, ?VacancySortField $sortBy, VacancySearcher $searcher): Response
    {
        $vacancies = $searcher->findByCountry($country, $sortBy ?? VacancySortField::SALARY);

        return $this->json(new VacancyListDTO($vacancies));
    }

    #[Route('/by-city/{city}', name:'by_city', methods: ['GET'], requirements: ['city' => '\w+'])]
    public function getByCity(City $city, ?VacancySortField $sortBy, VacancySearcher $searcher): Response
    {
        $vacancies = $searcher->findByCity($city, $sortBy ?? VacancySortField::SALARY);

        return $this->json(new VacancyListDTO($vacancies));
    }

    /**
     * @OA\Post(
     *   @OA\RequestBody(
     *     required=true,
     *     @Model(type=BestFitRequestDTO::class)
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Success",
     *     @Model(type=BestFitResponseDTO::class)
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad request"
     *   )
     * )
     */
    #[Route('/the-best', name:'get_the_best', methods: ['POST'], priority: 1)]
    public function getBest(BestFitRequestDTO $dto, VacancySearcher $searcher): Response
    {
        $vacancy = $searcher->findBestFit($dto);

        return $this->json(new BestFitResponseDTO($vacancy));
    }
}

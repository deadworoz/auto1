<?php

namespace App\Controller;

use App\Service\SumService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class SumController
{
    /**
     * @var SumService
     */
    private $sumService;

    /**
     * SumController constructor.
     * @param SumService $sumService
     */
    public function __construct(SumService $sumService)
    {
        $this->sumService = $sumService;
    }

    /**
     * @param string $a
     * @param string $b
     *
     * @return JsonResponse
     */
    public function sumAction(string $a, string $b) : JsonResponse
    {
        return new JsonResponse(['sum' => $this->sumService->makeSum($a, $b)], Response::HTTP_OK);
    }
}

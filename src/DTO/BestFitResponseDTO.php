<?php

declare(strict_types=1);

namespace App\DTO;

use App\Entity\Vacancy;

class BestFitResponseDTO
{

    public ?Vacancy $recommendedVacancy;

    public function __construct(?Vacancy $vacancy)
    {
        $this->recommendedVacancy = $vacancy;
    }
}

<?php

declare(strict_types=1);

namespace App\Repository\Criteria;

use App\Enum\City;

class CandidateWantsToLieLowInBrugesCriteria implements VacancyCriteriaInterface
{        
    private bool $isCandidateWantsToLieLowInBruges;

    public function __construct(bool $isCandidateWantsToLieLowInBruges)
    {
        $this->isCandidateWantsToLieLowInBruges = $isCandidateWantsToLieLowInBruges;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(array $row): bool
    {
        if (!$this->isCandidateWantsToLieLowInBruges) {
            return true;
        }
        
        return $row['city'] === City::BRUGES->getName();
    }
}

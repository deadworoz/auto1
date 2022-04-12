<?php

declare(strict_types=1);

namespace App\Repository\Criteria;

use App\Enum\SeniorityLevel;
use App\ValueObject\SkillList;

class BestFitCriteria implements VacancyCriteriaInterface
{
    private array $criteria = [];

    public function __construct(SkillList $skills, SeniorityLevel $level, bool $isCandidateWantsToLieLowInBruges)
    {
        $this->criteria[] = new EnoughSkillsCriteria($skills);
        $this->criteria[] = new CompetentLevelCriteria($level);
        $this->criteria[] = new CandidateWantsToLieLowInBrugesCriteria($isCandidateWantsToLieLowInBruges);
    }

    /**
     * @inheritdoc
     */
    public function __invoke(array $row): bool
    {
        $isSatisfied = true;
        foreach ($this->criteria as $criterion) {
            if (!$isSatisfied) {
                break;
            }

            $isSatisfied = $criterion($row);
        }

        return $isSatisfied;
    }
}

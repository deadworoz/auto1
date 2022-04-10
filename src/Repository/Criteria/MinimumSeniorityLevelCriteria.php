<?php

declare(strict_types=1);

namespace App\Repository\Criteria;

use App\Enum\SeniorityLevel;

class MinimumSeniorityLevelCriteria implements VacancyCriteriaInterface
{
    private SeniorityLevel $level;
    
    public function __construct(SeniorityLevel $level)
    {
        $this->level = $level;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(array $row): bool
    {
        $vacancyLevel = SeniorityLevel::from($row['seniorityLevel']);
        
        return $vacancyLevel->equalOrNext($this->level);
    }
}

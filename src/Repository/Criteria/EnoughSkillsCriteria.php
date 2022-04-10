<?php

declare(strict_types=1);

namespace App\Repository\Criteria;

use App\ValueObject\SkillList;

class EnoughSkillsCriteria implements VacancyCriteriaInterface
{
    private const ENOUGH_COVERAGE_PERCENT = 80;
    
    private SkillList $skills;
    
    public function __construct(SkillList $skills)
    {
        $this->skills = $skills;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(array $row): bool
    {
        $vacancySkills = SkillList::fromString($row['requiredSkills']);        
        return $this->skills->covers($vacancySkills, self::ENOUGH_COVERAGE_PERCENT);
    }
}

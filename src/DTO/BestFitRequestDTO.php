<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\SeniorityLevel;
use App\ValueObject\SkillList;

class BestFitRequestDTO
{
    public $skills = null;
    public $seniorityLevel = null;
    public $wantsToLieLowInBruges = null;

    public function getSkills(): SkillList
    {
        return SkillList::fromString('Java, J2SE, Spring, Bamboo, Docker');
    }

    public function getSeniorityLevel(): SeniorityLevel
    {
        return SeniorityLevel::SENIOR;
    }

    public function isCandidateWantsToLieLowInBruges(): bool
    {
        return true;
    }
}

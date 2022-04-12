<?php

declare(strict_types=1);

namespace App\DTO;

use App\ArgumentResolver\ResolvableDTOInterface;
use App\Enum\SeniorityLevel;
use App\ValueObject\SkillList;
use Symfony\Component\Validator\Constraints as Assert;

class BestFitRequestDTO implements ResolvableDTOInterface
{
    #[Assert\NotBlank()]
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('string'),
    ])]
    public mixed $skills = null;

    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Assert\Choice(callback: [SeniorityLevel::class, 'choices'])]
    public mixed $seniorityLevel = null;

    #[Assert\NotNull()]
    #[Assert\Type('bool')]
    public mixed $wantsToLieLowInBruges = null;

    public function getSkillList(): SkillList
    {
        assert(is_array($this->skills));

        return SkillList::fromStringArray($this->skills);
    }

    public function getLevel(): SeniorityLevel
    {
        assert(is_string($this->seniorityLevel));

        return SeniorityLevel::from($this->seniorityLevel);
    }

    public function isCandidateWantsToLieLowInBruges(): bool
    {
        return filter_var($this->wantsToLieLowInBruges, FILTER_VALIDATE_BOOLEAN);
    }
}

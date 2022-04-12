<?php

declare(strict_types=1);

namespace App\DTO;

use App\ArgumentResolver\ResolvableDTOInterface;
use App\Enum\SeniorityLevel;
use App\ValueObject\SkillList;
use OpenApi\Annotations as OA;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Validator\Constraints as Assert;

class BestFitRequestDTO implements ResolvableDTOInterface
{
    #[Assert\NotBlank()]
    #[Assert\Type('array')]
    #[Assert\All([
        new Assert\Type('string'),
    ])]
    /**
     * @OA\Property(
     *   type="array",
     *   @OA\Items(type="string"),
     *   example={"PHP", "Docker", "Symfony", "SOLID", "PHPUnit", "Behat", "REST"}
     * )
     */
    public mixed $skills = null;

    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    #[Assert\Choice(callback: [SeniorityLevel::class, 'choices'])]
    /**
     * @OA\Property(type=SeniorityLevel::class, example="Senior")
     */
    public mixed $seniorityLevel = null;

    #[Assert\NotNull()]
    #[Assert\Type('bool')]
    /**
     * @OA\Property(type="boolean", example=false)
     */
    public mixed $wantsToLieLowInBruges = null;

    #[Ignore]
    public function getSkillList(): SkillList
    {
        assert(is_array($this->skills));

        return SkillList::fromStringArray($this->skills);
    }

    #[Ignore]
    public function getLevel(): SeniorityLevel
    {
        assert(is_string($this->seniorityLevel));

        return SeniorityLevel::from($this->seniorityLevel);
    }

    #[Ignore]
    public function isCandidateWantsToLieLowInBruges(): bool
    {
        return filter_var($this->wantsToLieLowInBruges, FILTER_VALIDATE_BOOLEAN);
    }
}

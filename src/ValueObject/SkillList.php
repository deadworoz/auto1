<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\Currency;

final class SkillList implements \JsonSerializable
{
    private const ONE_HUNDREED_PERCENT = 100;

    /** @var string[] */
    private array $skills = [];

    public static function fromString(string $skillsStr, string $delimiter = ','): self
    {
        $skills = array_map(static function (string $skill) {
            return trim($skill);
        }, explode($delimiter, $skillsStr));

        return new self($skills);
    }

    public function covers(SkillList $other, int $percent): bool
    {
        if (count($other->skills) === 0) {
            return true;
        }

        $diff = array_diff($this->skills, $other->skills);

        return self::ONE_HUNDREED_PERCENT * (count($this->skills) - count($diff)) / count($other->skills) > $percent;
    }

    /**
     * @param string[] $skills
     */
    private function __construct(array $skills)
    {
        $this->skills = $skills;
    }

    public function jsonSerialize(): array
    {
        return $this->skills;
    }
}

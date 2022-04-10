<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\Currency;

final class SkillList implements \JsonSerializable
{   
    /** @var string[] */
    private array $skills = [];
        
    static public function fromString(string $skillsStr, string $delimiter = ','): self
    {
        $skills = array_map(static function (string $skill) {
            return trim($skill);
        }, explode($delimiter, $skillsStr));
                
        return new self($skills);
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

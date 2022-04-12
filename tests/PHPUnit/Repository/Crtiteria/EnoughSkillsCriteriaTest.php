<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Repository\Criteria;

use App\Repository\Criteria\EnoughSkillsCriteria;
use App\ValueObject\SkillList;
use PHPUnit\Framework\TestCase;

final class EnoughSkillsCriteriaTest extends TestCase
{

    /**
     * @dataProvider skillsProvider
     */
    public function testInvoke(string $candidateSkills, string $vacancySkills, bool $isVacancySkillsCovered): void
    {
        $criteria = new EnoughSkillsCriteria(SkillList::fromString($candidateSkills));

        $row['requiredSkills'] = $vacancySkills;
        $this->assertSame($criteria($row), $isVacancySkillsCovered);
    }


    public function skillsProvider(): array
    {
        return [
            ['PHP, Docker, REST, SQL, ElasticSearch', 'PHP, Docker, REST, SQL, ElasticSearch', true],
            ['PHP, Docker, REST, SQL', 'PHP, Docker, REST, SQL, ElasticSearch', true],
            ['PHP, Docker, SQL', 'PHP, Docker, REST, SQL, ElasticSearch', false],
        ];
    }
}

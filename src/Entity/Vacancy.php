<?php

declare(strict_types=1);

namespace App\Entity;

use App\Enum\City;
use App\Enum\CompanyDomain;
use App\Enum\CompanySize;
use App\Enum\Currency;
use App\Enum\SeniorityLevel;
use App\Enum\VacancySortField;
use App\ValueObject\Money;
use App\ValueObject\SkillList;

class Vacancy implements \JsonSerializable
{
    private int $id;

    private string $jobTitle;

    private SeniorityLevel $level;

    private City $city;

    private Money $salary;

    private SkillList $skills;

    private CompanySize $companySize;

    private CompanyDomain $companyDomain;

    public function __construct(
        int $id,
        string $jobTitle,
        SeniorityLevel $level,
        City $city,
        Money $salary,
        SkillList $skills,
        CompanySize $companySize,
        CompanyDomain $companyDomain,
    ) {
        $this->id = $id;
        $this->jobTitle = $jobTitle;
        $this->level = $level;
        $this->city = $city;
        $this->salary = $salary;
        $this->skills = $skills;
        $this->companySize = $companySize;
        $this->companyDomain = $companyDomain;
    }

    public static function fromArray(array $dto): self
    {
        return new self(
            (int) $dto['id'],
            $dto['jobTitle'],
            SeniorityLevel::from($dto['seniorityLevel']),
            City::from($dto['city']),
            new Money((int) $dto['salary'], Currency::from($dto['currency'])),
            SkillList::fromString($dto['requiredSkills']),
            CompanySize::from($dto['companySize']),
            CompanyDomain::from($dto['companyDomain']),
        );
    }

    public static function getComparator(VacancySortField $sortBy): callable
    {
        return match ($sortBy) {
            VacancySortField::SALARY => static::getSalaryComparator(),
            VacancySortField::SENIORITY_LEVEL => static::getSeniorityLevelComparator(),
        };
    }

    public static function getSalaryComparator(): callable
    {
        return static function (Vacancy $a, Vacancy $b): int {
            $moneyComparator = Money::getComparator();

            return $moneyComparator($a->salary, $b->salary);
        };
    }

    public static function getSeniorityLevelComparator(): callable
    {
        return static function (Vacancy $a, Vacancy $b): int {
            $levelComparator = SeniorityLevel::getComparator();

            return $levelComparator($a->level, $b->level);
        };
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'seniorityLevel' => $this->level->getTitle(),
            'country' => $this->city->getCountryCode(),
            'city' => $this->city->getName(),
            'salary' => $this->salary->getValue(),
            'currency' => $this->salary->getCurrencyCode(),
            'requiredSkills' => $this->skills,
            'companySize' => $this->companySize->getTitle(),
            'companyDomain' => $this->companyDomain->getTitle(),
        ];
    }
}

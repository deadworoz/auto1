<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Vacancy;
use App\Enum\City;
use App\Enum\Country;
use App\Store\StoreInterface;

class VacancyRepository implements VacancyRepositoryInterface
{
    private StoreInterface $store;
    
    public function __construct(StoreInterface $store)
    {
        $this->store = $store;
    }
    
    public function findById(int $id): ?Vacancy
    {
        $byIdCallback = static function (array $row) use ($id) {
            $rowId = (int) $row['id'];
            return $rowId === $id;
        };
        
        $vacancyRows = $this->store->getRows($byIdCallback);
        return count($vacancyRows) > 0 ? Vacancy::fromArray($vacancyRows[0]) : null;
    }

    /**
     * @inheritdoc
     */
    public function findByCountry(Country $country): array
    {
        $byCountryCallback = static function (array $row) use ($country) {            
            return $row['country'] === $country->getCode();
        };
        
        return $this->store->getRows($byCountryCallback);
    }

    /**
     * @inheritdoc
     */
    public function findByCity(City $city): array
    {
        $byCityCallback = static function (array $row) use ($city) {            
            return $row['city'] === $city->getName();
        };
        
        return $this->store->getRows($byCityCallback);
    }
}

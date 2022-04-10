<?php

namespace App\Enum;

enum City: string
{
    case BERLIN = 'Berlin';
    case HAMBURG = 'Hamburg';
    
    case BARCELONA = 'Barcelona';
    
    case LISBON = 'Lisbon';
    
    case AMSTERDAM = 'Amsterdam';
    case ROTTERDAM = 'Rotterdam';

    case ANTWERP = 'Antwerp';
    case BRUGES = 'Bruges';

    case DUBLIN = 'Dublin';

    public function getName(): string
    {
        return $this->value;
    }

    public function getCountry(): Country
    {
        return match($this) {
            City::BERLIN, City::HAMBURG => Country::GERMANY,
            City::BARCELONA => Country::SPAIN,
            City::LISBON => Country::PORTUGAL,
            City::AMSTERDAM, City::ROTTERDAM => Country::NETHERLANDS,
            City::ANTWERP, City::BRUGES => Country::BELGIUM,
            City::DUBLIN => Country::IRELAND,
        };
    }

    public function getCountryCode(): string
    {
        return $this->getCountry()->getCode();
    }
}

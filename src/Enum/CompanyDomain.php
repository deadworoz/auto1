<?php

namespace App\Enum;

enum CompanyDomain: string
{
    case AUTOMOTIVE = 'Automotive';
    case COMMUNICATION = 'Communication';
    case FINTECH = 'FinTech';
    case HEALTH = 'Health';
    case LOGISTICS = 'Logistics';
    case MINING = 'Mining'; 
    case REAL_ESTATE = 'Real Estate';            

    public function getTitle(): string
    {
        return $this->value;
    }
}

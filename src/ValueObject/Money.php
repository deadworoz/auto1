<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Enum\Currency;

final class Money
{
    private int $value;
    private Currency $currency;
    
    public function __construct(int $value, Currency $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getCurrencyCode(): string
    {
        return $this->currency->getCode();
    }
}

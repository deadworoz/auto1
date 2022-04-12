<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\ValueObject;

use App\Enum\Currency;
use App\ValueObject\Money;
use PHPUnit\Framework\TestCase;

final class MoneyTest extends TestCase
{
    /**
     * @dataProvider moneyProvider
     */
    public function testComparator(Money $a, Money $b, int $result): void
    {
        $comparator = Money::getComparator();
        $this->assertSame($comparator($a, $b) > 0, $result > 0);
        $this->assertSame($comparator($a, $b) < 0, $result < 0);
    }

    public function moneyProvider(): array
    {
        $value = 1000;
        $currency = Currency::SVU;

        return [
            [new Money($value, $currency), new Money($value, $currency), 0],
            [new Money($value, $currency), new Money($value + 1, $currency), -1],
            [new Money($value + 1, $currency), new Money($value, $currency), 1],
        ];
    }
}

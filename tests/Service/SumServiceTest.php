<?php

namespace Tests\App\Service;

use App\Service\SumService;
use PHPUnit\Framework\TestCase;

/**
 * Class SumServiceTest
 */
class SumServiceTest extends TestCase
{
    /**
     * Check sum service
     */
    public function testMakeSum()
    {
        $service = new SumService();

        self::assertEquals(5, $service->makeSum(2, 3));
    }
}

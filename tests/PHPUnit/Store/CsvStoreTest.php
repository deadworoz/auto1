<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Store;

use App\ResourceProvider\PhpResourceProviderInterface;
use App\Store\CsvStore;
use PHPUnit\Framework\TestCase;

final class CsvStoreTest extends TestCase
{
    public function testSelectRows(): void
    {
        $csvData = [];
        for ($i = 0; $i < 5; $i++) {
            $row = [
                'id' => (string) $i,
                'name' => "User {$i}",
                'someField' => '123',
            ];
            $csvData[] = $row;
        }
        $resource = fopen('php://memory', 'rw');
        $header = array_keys($csvData[0]);
        fputcsv($resource, $header);
        foreach ($csvData as $row) {
            fputcsv($resource, $row);
        }
        rewind($resource);

        $resourceProvider = $this->createStub(PhpResourceProviderInterface::class);
        $resourceProvider
            ->method('getResource')
            ->willReturn($resource);

        $csvStore = new CsvStore($resourceProvider);
        $gotCsvData = $csvStore->getRows();
        $this->assertSame($csvData, $gotCsvData);
    }
}

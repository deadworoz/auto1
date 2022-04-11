<?php

declare(strict_types=1);

namespace App\Store;

use App\ResourceProvider\PhpResourceProviderInterface;

class CsvStore implements StoreInterface
{
    private PhpResourceProviderInterface $provider;

    public function __construct(PhpResourceProviderInterface $provider)
    {
        $this->provider = $provider;
    }

    /**
     * @inheritdoc
     */
    public function getRows(?callable $selector = null): array
    {
        $resource = $this->getResource();

        try {
            $rows = $this->selectRows($resource, $selector);
        } catch (\Throwable $e) {
            throw $e;
        } finally {
            $this->provider->destroyResource($resource);
        }

        return $rows;
    }

    private function getResource()
    {
        $resource = $this->provider->getResource();
        if ($resource === false) {
            throw new CsvStoreException("Couldn't open csv file");
        }

        return $resource;
    }

    /**
     * @throws CsvStoreException
     */
    private function selectRows($resource, ?callable $selector): array
    {
        $header = fgetcsv($resource);
        if ($header === false) {
            throw new CsvStoreException("Couldn't read csv header");
        }

        $rows = [];
        while (true) {
            $values = fgetcsv($resource);
            if ($values === false) {
                break;
            }

            if (count($values) === 1 && $values[0] === null) {
                break;
            }

            if (count($values) !== count($header)) {
                throw new CsvStoreException("Header and row have different count of fields");
            }

            $row = array_combine($header, $values);
            $isSelected = $selector ? $selector($row) : true;
            if ($isSelected) {
                $rows[] = $row;
            }
        }

        return $rows;
    }
}

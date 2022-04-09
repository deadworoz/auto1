<?php

declare(strict_types=1);

namespace App\Store;

interface StoreInterface
{
    /**
     * @throws StoreException
     */
    public function getRows(callable $selector = null): array;
}

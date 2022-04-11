<?php

declare(strict_types=1);

namespace App\ResourceProvider;

interface PhpResourceProviderInterface
{
    /**
     * @return resource|false
     */
    public function getResource(): mixed;

    /**
     * @param resource|false $fp
     */
    public function destroyResource(mixed $fp): bool;
}

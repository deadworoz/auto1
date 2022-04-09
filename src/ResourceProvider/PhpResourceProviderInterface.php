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
     * @param resource $fp
     */
    public function destroyResource(mixed $fp): bool;
}

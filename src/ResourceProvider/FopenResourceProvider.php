<?php

declare(strict_types=1);

namespace App\ResourceProvider;

class FopenResourceProvider implements PhpResourceProviderInterface
{
    private string $name;
    private string $mode;

    public function __construct(string $resourceName, string $mode = 'r')
    {
        $this->name = $resourceName;
        $this->mode = $mode;
    }

    /**
     * @inheritdoc
     */
    public function getResource(): mixed
    {
        return fopen($this->name, $this->mode);
    }

    /**
     * @inheritdoc
     */
    public function destroyResource(mixed $fp): bool
    {
        if (is_resource($fp)) {
            return fclose($fp);
        }

        return false;
    }
}

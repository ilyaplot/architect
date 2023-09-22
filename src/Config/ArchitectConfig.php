<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Config;

use Symfony\Component\Config\Builder\ConfigBuilderInterface;

final class ArchitectConfig implements ConfigBuilderInterface
{
    /** @var non-empty-string[] */
    private array $paths = [];

    /**
     * @param non-empty-string ...$paths
     */
    public function paths(string ...$paths): self
    {
        foreach ($paths as $path) {
            $this->paths[] = $path;
        }

        return $this;
    }

    public function toArray(): array
    {
        $config = [];

        if ($this->paths !== []) {
            $config['paths'] = $this->paths;
        }

        return $config;
    }

    public function getExtensionAlias(): string
    {
        return 'architect';
    }
}

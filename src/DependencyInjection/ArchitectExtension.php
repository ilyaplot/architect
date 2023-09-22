<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

use function getcwd;

class ArchitectExtension extends Extension implements PrependExtensionInterface
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $configs = $this->processConfiguration($configuration, $configs);

        /** @psalm-suppress MixedArgument */
        $container->setParameter('paths', $configs['paths']);
    }

    public function prepend(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('projectDirectory')) {
            $container->setParameter('projectDirectory', getcwd());
        }
        if (!$container->hasParameter('paths')) {
            $container->setParameter('paths', []);
        }
    }
}

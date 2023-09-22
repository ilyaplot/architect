<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\DependencyInjection;

use Exception;
use Ilyaplot\Architect\DependencyInjection\Exception\ConfigurationException;
use SplFileInfo;
use Symfony\Component\Config\Builder\ConfigBuilderGenerator;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Config\Loader\DelegatingLoader;
use Symfony\Component\Config\Loader\LoaderResolver;
use Symfony\Component\Console\DependencyInjection\AddConsoleCommandPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\Filesystem\Path;

final class ServiceContainerBuilder
{
    private ?SplFileInfo $configFile = null;

    public function __construct(private readonly string $workingDirectory)
    {
    }

    public function withConfig(?string $configFile): self
    {
        if (null === $configFile) {
            return $this;
        }

        $builder = clone $this;

        if (Path::isRelative($configFile)) {
            /** @throws void */
            $configFile = Path::makeAbsolute($configFile, $this->workingDirectory);
        }

        $builder->configFile = new SplFileInfo($configFile);

        return $builder;
    }

    /**
     * @throws ConfigurationException
     */
    public function build(): ContainerBuilder
    {
        $container = new ContainerBuilder();

        $container->addCompilerPass(new AddConsoleCommandPass());

//        $container->setParameter('currentWorkingDirectory', $this->workingDirectory);

//        self::registerCompilerPasses($container);

        $loader = new PhpFileLoader($container, new FileLocator([__DIR__ . '/../../config']));
        $filename = 'services.php';

        try {
            $loader->load($filename);
        } catch (Exception $exception) {
            throw new ConfigurationException(
                message: sprintf('Could not load %s. Reason: %s', $filename, $exception->getMessage()),
                previous: $exception,
            );
        }

        $container->registerExtension(new ArchitectExtension());

//        $container->setParameter('projectDirectory', $this->workingDirectory);
        if (null !== $this->configFile) {
            self::loadConfiguration($container, $this->configFile);
        }

        $container->compile(true);

        return $container;
    }

    /**
     * @throws ConfigurationException
     */
    private static function loadConfiguration(ContainerBuilder $container, SplFileInfo $configFile): void
    {
        $configPathInfo = $configFile->getPathInfo()
            ?? throw new ConfigurationException(sprintf(
                'Could not load %s. Reason: Unable to load config: Invalid or missing path.',
                $configFile->getFilename()
            ));

//        $container->setParameter('projectDirectory', $configPathInfo->getPathname());

        $loader = new DelegatingLoader(new LoaderResolver([
            new PhpFileLoader(
                container: $container,
                locator: new FileLocator([$configPathInfo->getPathname()]),
                generator: new ConfigBuilderGenerator('.'),
            ),
        ]));

        try {
            $loader->load($configFile->getFilename());
        } catch (Exception $exception) {
            throw new ConfigurationException(
                message: sprintf('Could not load %s. Reason: %s', $configFile->getFilename(), $exception->getMessage()),
                previous: $exception,
            );
        }
    }
}

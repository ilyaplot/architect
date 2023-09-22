<?php

declare(strict_types=1);

use Ilyaplot\Architect\Console\Command\AnalyseCommand;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->defaults()
        ->autowire();

    $services->set(PhpFileLoader::class);

    /*
     * Console
     */
    $services
        ->set(AnalyseCommand::class)
        ->autowire()
        ->tag('console.command');
};

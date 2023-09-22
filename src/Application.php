<?php

declare(strict_types=1);

namespace Ilyaplot\Architect;

use Ilyaplot\Architect\Console\Command\AnalyseCommand;
use Ilyaplot\Architect\DependencyInjection\Exception\ConfigurationException;
use Ilyaplot\Architect\DependencyInjection\ServiceContainerBuilder;
use RuntimeException;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\CommandLoader\CommandLoaderInterface;
use Symfony\Component\Console\Exception\ExceptionInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use function getcwd;
use function in_array;

use const DIRECTORY_SEPARATOR;

final class Application extends SymfonyApplication
{
    public const VERSION = '@git-version@';

    public function __construct()
    {
        parent::__construct('architect', self::VERSION);
    }

    /**
     * @throws InvalidArgumentException
     */
    protected function getDefaultInputDefinition(): InputDefinition
    {
        $definition = parent::getDefaultInputDefinition();

        $definition->addOptions([
            new InputOption(
                '--help',
                '-h',
                InputOption::VALUE_NONE,
                'Display help for the given command. When no command is given display help for the <info>analyse</info> command'
            ),
            new InputOption(
                '--config-file',
                '-c',
                InputOption::VALUE_REQUIRED,
                'Location of configuration',
                getcwd() . DIRECTORY_SEPARATOR . 'architect.config.php'
            ),
        ]);

        return $definition;
    }

    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        if (false === ($currentWorkingDirectory = getcwd())) {
            // @todo
//            throw CannotGetCurrentWorkingDirectoryException::cannotGetCWD();
        }

        try {
            $input->bind($this->getDefinition());
        } catch (ExceptionInterface) {
            // Errors must be ignored, full binding/validation happens later when the command is known.
        }

        if (null === $input->getArgument('command') && true === $input->getOption('version')) {
            return parent::doRun($input, $output);
        }

        /** @var string|numeric|null $configFile */
        $configFile = $input->getOption('config-file');
        $config = $input->hasOption('config-file')
            ? (string)$configFile
            : $currentWorkingDirectory . DIRECTORY_SEPARATOR . 'architect.php';

        $factory = new ServiceContainerBuilder($currentWorkingDirectory);

        if (!in_array($input->getArgument('command'), ['init', 'help'], true)) {
            $factory = $factory->withConfig($config);
        }
//        if (false === $input->hasParameterOption('--no-cache', true)) {
//            $factory = $factory->withCache($cache);
//        }

        try {
            $container = $factory->build();
            $commandLoader = $container->get('console.command_loader');
            if (!$commandLoader instanceof CommandLoaderInterface) {
                throw new RuntimeException('CommandLoader not initialized. Commands can not be registered.');
            }
            $this->setCommandLoader($commandLoader);
            $this->setDefaultCommand('analyse');
        } catch (ConfigurationException $e) {
            if (false === $input->hasParameterOption(['--help', '-h'], true)) {
                throw $e;
            }

            $this->setDefaultCommand('help');
        }

        return parent::doRun($input, $output);
    }
}

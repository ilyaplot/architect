<?php

declare(strict_types=1);

namespace Ilyaplot\Architect\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AnalyseCommand extends Command
{
    public static $defaultName = 'analyse|analyze';
    public static $defaultDescription = 'Analyses your project';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('TEST ANALYSE');
        return self::SUCCESS;
    }
}

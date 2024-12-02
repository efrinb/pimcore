<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CustomCommand extends Command
{
    protected static $defaultName = 'app:custom-command';

    protected function configure()
    {
        $this
            ->setDescription('A custom CLI command in Pimcore')
            ->setHelp('This is a sample CLI command for Pimcore.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello, this is a custom Pimcore CLI command.');
        return Command::SUCCESS;
    }
}

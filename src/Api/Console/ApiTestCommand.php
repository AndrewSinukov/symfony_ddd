<?php

namespace App\Api\Console;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ApiTestCommand extends Command
{
    /**
     * {@inheritDoc}
     */
    protected function configure(): void
    {
        $this
            // the name of the command (the part after "bin/console")
            ->setName('hello:Api')

            // the short description shown while running "php bin/console list"
            ->setDescription('Echo hello Api')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you to write hello Api to screen')
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello Api');
    }
}

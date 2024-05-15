<?php

namespace Src\Command;

use Src\Queue\MessageQueueManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'messenger:consume')]
class ConsumeCommand extends Command
{
    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        (new MessageQueueManager())->dequeue();

        return Command::SUCCESS;
    }
}
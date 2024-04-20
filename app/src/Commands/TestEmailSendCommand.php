<?php

namespace Src\Commands;

use Src\MailerFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Email;

#[AsCommand(name: 'test:send-email')]
class TestEmailSendCommand extends Command
{
    /**
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $email = (new Email())
            ->from('example@example.com')
            ->to($_ENV['TEST_EMAIL'])
            ->subject('Test email')
            ->text('Test email');

        MailerFactory::getMailer()->send($email);
        $output->writeln('<info>' . 'Message has been sent!' . '</info>');

        return Command::SUCCESS;
    }
}
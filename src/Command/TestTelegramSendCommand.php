<?php

namespace Src\Command;

use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use Src\TelegramBot;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'test:send-telegram')]
class TestTelegramSendCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $message = '';

        $telegramBot = new TelegramBot();
        $telegramBot->sendMessage(
            text: $message,
            chat_id: $_ENV['TEST_TELEGRAM_ID'],
            parse_mode: ParseMode::MARKDOWN_LEGACY
        );

        $output->writeln('<info>' . 'Message has been sent!' . '</info>');

        return Command::SUCCESS;
    }
}
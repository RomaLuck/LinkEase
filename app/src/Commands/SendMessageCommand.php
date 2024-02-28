<?php

namespace Src\Commands;

use SergiX44\Nutgram\Nutgram;
use Src\Database\EntityManagerFactory;
use Src\Entity\UserSettings;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-message')]
class SendMessageCommand extends Command
{
    public function __construct(private Nutgram $bot)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentTime = (new \DateTime());
        $entityManager = EntityManagerFactory::create();
        $userSettings = $entityManager->getRepository(UserSettings::class)->findBy(['time' => $currentTime]);
        if ($userSettings !== []) {
            foreach ($userSettings as $userSetting) {
                $user = $userSetting->getUser();
                $this->bot->sendMessage('Hi', $user->getTelegramChatId());
            }
        }
        return Command::SUCCESS;
    }
}
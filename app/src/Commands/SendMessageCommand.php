<?php

namespace Src\Commands;

use SergiX44\Nutgram\Nutgram;
use Src\Database\EntityManagerFactory;
use Src\Entity\UserSettings;
use DateInterval;
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

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentDate = new \DateTime();
        $currentTime = $currentDate->setDate(1970, 1, 1);

        $maxTime = clone $currentTime;
        $maxTime->add(new DateInterval('PT02M'));

        $entityManager = EntityManagerFactory::create();
        $userSettings = $entityManager
            ->getRepository(UserSettings::class)
            ->findSettingsBetweenTimes($currentTime, $maxTime);

        if ($userSettings !== []) {
            foreach ($userSettings as $userSetting) {
                $user = $userSetting->getUser();
                $this->bot->sendMessage('Hi', $user->getTelegramChatId());
            }
        }
        return Command::SUCCESS;
    }
}
<?php

namespace Src\Command;

use GuzzleHttp\Exception\GuzzleException;
use Src\Database\EntityManagerFactory;
use Src\Entity\UserSettings;
use Src\SendDataService\AdaptiveMessageSender;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:send-message')]
class SendUserMessageCommand extends Command
{
    /**
     * @throws GuzzleException
     * @throws \JsonException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $currentDate = new \DateTime();
        #we are going to work only with time
        $currentTime = $currentDate->setDate(1970, 1, 1);

        $maxTime = clone $currentTime;
        $maxTime->modify('-1 minutes');

        $entityManager = EntityManagerFactory::create();

        $userSettings = $entityManager
            ->getRepository(UserSettings::class)
            ->findSettingsBetweenTimes($currentTime, $maxTime);

        if ($userSettings !== []) {
            foreach ($userSettings as $userSetting) {
                $sendDataProcessor = new AdaptiveMessageSender($userSetting);
                if ($userSetting->getApiRequestUrl() !== '') {
                    $sendDataProcessor->sendMessage();
                    $output->writeln('<info>' . 'Message has been sent!' . '</info>');
                }
            }
        }
        return Command::SUCCESS;
    }
}
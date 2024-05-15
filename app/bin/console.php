<?php

use Dotenv\Dotenv;
use Src\Command\ConsumeCommand;
use Src\Command\Fixture\CollectDataCommand;
use Src\Command\SendUserMessageCommand;
use Src\Command\TestEmailSendCommand;
use Src\Command\TestTelegramSendCommand;
use Src\LoggerFactory;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$logger = (new LoggerFactory())->getLogger('console');

try {
    $application = new Application();
    $application->add(new SendUserMessageCommand());
    $application->add(new CollectDataCommand());
    $application->add(new TestEmailSendCommand());
    $application->add(new ConsumeCommand());
    $application->add(new TestTelegramSendCommand());
    $application->run();
} catch (Exception $e) {
    $logger->error($e->getMessage());
}
<?php

use Dotenv\Dotenv;
use Src\Commands\ConsumeCommand;
use Src\Commands\Fixtures\CollectDataCommand;
use Src\Commands\SendUserMessageCommand;
use Src\Commands\TestEmailSendCommand;
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
    $application->run();
} catch (Exception $e) {
    $logger->error($e->getMessage());
}
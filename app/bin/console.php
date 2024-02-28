<?php

use Dotenv\Dotenv;
use Src\Commands\SendMessageCommand;
use Src\TelegramBot;
use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();


try {
    $application = new Application();

    $application->add(new SendMessageCommand(new TelegramBot()));

    $application->run();
} catch (Exception $e) {
}
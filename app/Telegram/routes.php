<?php

use Core\LoggerFactory;
use Dotenv\Dotenv;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;
use Telegram\Conversation\RegisterConversation;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$logger = (new LoggerFactory())->getLogger('telegram_bot');

try {
    $config = new Configuration(
        logger: $logger,
    );

    $bot = new Nutgram($_ENV['TELEGRAM_BOT_TOKEN'], $config);

    $bot->onCommand('start', RegisterConversation::class);

    $bot->fallback(function (Nutgram $bot) {
        $bot->sendMessage('Sorry, I don\'t understand.');
    });

    $bot->run();
} catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {
    $logger->error($e->getMessage());
    $logger->error($e->getTraceAsString());
}
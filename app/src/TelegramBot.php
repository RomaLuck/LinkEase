<?php

namespace Src;

use Dotenv\Dotenv;
use SergiX44\Nutgram\Configuration;
use SergiX44\Nutgram\Nutgram;

class TelegramBot extends Nutgram
{
    public function __construct(?Configuration $configuration = null)
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
        parent::__construct($_ENV['TELEGRAM_BOT_TOKEN'], $configuration);
    }
}
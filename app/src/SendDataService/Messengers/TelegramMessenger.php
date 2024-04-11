<?php

namespace Src\SendDataService\Messengers;

use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use Src\Entity\User;
use Src\TelegramBot;

class TelegramMessenger implements SendDataInterface
{
    public function send(User $user, string $message): void
    {
        $telegramBot = new TelegramBot();
        $telegramBot->sendMessage(
            text: rtrim($message, ', '),
            chat_id: $user->getTelegramChatId(),
            parse_mode: ParseMode::MARKDOWN_LEGACY
        );
    }
}
<?php

namespace Src\SendDataService\Messengers;

use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use Src\Entity\User;
use Src\TelegramBot;

class TelegramMessenger implements SendDataInterface
{
    public function send(User $user, string $message): void
    {
        $preparedMessage = $this->prepareMessage($message);

        $telegramBot = new TelegramBot();
        $telegramBot->sendMessage(
            text: $preparedMessage,
            chat_id: $user->getTelegramChatId(),
            parse_mode: ParseMode::MARKDOWN_LEGACY
        );
    }

    private function prepareMessage(string $message): string
    {
        $message = str_replace(
            ['<h4>', '</h4>', '</p>'],
            ['*', "*\n", "\n"],
            $message
        );

        return strip_tags($message);
    }
}
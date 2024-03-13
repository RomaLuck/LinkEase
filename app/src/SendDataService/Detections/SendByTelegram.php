<?php

namespace Src\SendDataService\Detections;

use Doctrine\Common\Collections\ArrayCollection;
use SergiX44\Nutgram\Telegram\Properties\ParseMode;
use Src\Entity\User;
use Src\TelegramBot;
use function Symfony\Component\String\u;

class SendByTelegram implements SendDataInterface
{
    public function send(User $user, ArrayCollection $data): void
    {
        $current = $data->get('current');
        $currentUnits = $data->get('current_units');
        $daily = $data->get('daily');
        $dailyUnits = $data->get('daily_units');

        $telegramBot = new TelegramBot();
        if (is_array($daily) && $daily !== []) {
            $dayNum = count($daily[array_key_first($daily)]);
            for ($i = 0; $i < $dayNum; $i++) {
                $dailyMessage = "Daily:\n";
                foreach ($daily as $item => $value) {
                    if (is_array($value) && array_key_exists($i, $value) && array_key_exists($item, $dailyUnits)) {
                        $name = u($item)->replaceMatches('!\dm!iu', '')->replaceMatches('!_+!iu', ' ')->toString();
                        $dailyMessage .= $name . " : " . $value[$i] . "(" . $dailyUnits[$item] . "), \n";
                    }
                }
                $telegramBot->sendMessage(
                    text: rtrim($dailyMessage, ', '),
                    chat_id: $user->getTelegramChatId(),
                    parse_mode: ParseMode::MARKDOWN_LEGACY
                );
            }
        }
        if (is_array($current) && $current !== []) {
            $currentMessage = "Current:\n";
            foreach ($current as $item => $value) {
                if (array_key_exists($item, $currentUnits)) {
                    $name = u($item)->replaceMatches('!\dm!iu', '')->replaceMatches('!_+!iu', ' ')->toString();
                    $currentMessage .= $name . " : " . $value . "(" . $currentUnits[$item] . "), \n";
                }
            }
            $telegramBot->sendMessage(
                text: rtrim($currentMessage, ', '),
                chat_id: $user->getTelegramChatId(),
                parse_mode: ParseMode::MARKDOWN_LEGACY
            );
        }
    }
}
<?php

namespace Src\SendDataService\Detections;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Entity\User;
use Src\TelegramBot;

class SendByTelegram implements SendDataInterface
{
    public function send(User $user, ArrayCollection $data): void
    {
        $hi = 'Hi';
        (new TelegramBot())->sendMessage($hi, $user->getTelegramChatId());
    }
}
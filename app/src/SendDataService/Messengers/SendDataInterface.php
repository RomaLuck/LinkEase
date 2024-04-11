<?php

namespace Src\SendDataService\Messengers;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Entity\User;

interface SendDataInterface
{
    public function send(User $user, string $message): void;
}
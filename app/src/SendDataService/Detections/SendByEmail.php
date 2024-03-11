<?php

namespace Src\SendDataService\Detections;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Entity\User;

class SendByEmail implements SendDataInterface
{

    public function send(User $user, ArrayCollection $data): void
    {
        // TODO: Implement send() method.
    }
}
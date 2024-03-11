<?php

namespace Src\SendDataService\Detections;

use Doctrine\Common\Collections\ArrayCollection;
use Src\Entity\User;

interface SendDataInterface
{
    public function send(User $user, ArrayCollection $data): void;
}
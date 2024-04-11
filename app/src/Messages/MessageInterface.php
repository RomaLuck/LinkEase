<?php

namespace Src\Messages;

use Doctrine\Common\Collections\ArrayCollection;

interface MessageInterface
{
    public function getMessage(ArrayCollection $data): string;

    public function getFeature(): string;

    public function getMessenger(): string;
}
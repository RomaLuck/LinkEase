<?php

namespace Src\SendDataService\Messages;

interface MessageInterface
{
    public function getMessage(): string;
}
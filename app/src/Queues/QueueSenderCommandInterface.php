<?php

namespace Src\Queues;

interface QueueSenderCommandInterface
{
    public function execute(): void;
}
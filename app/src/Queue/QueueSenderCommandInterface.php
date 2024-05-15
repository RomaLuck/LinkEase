<?php

namespace Src\Queue;

interface QueueSenderCommandInterface
{
    public function execute(): void;
}
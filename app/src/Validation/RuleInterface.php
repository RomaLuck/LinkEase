<?php

namespace Src\Validation;

interface RuleInterface
{
    public function validate($value): bool;

    public function getMessage($value): string;
}
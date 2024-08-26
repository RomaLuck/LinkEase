<?php

namespace Src\Validation;

class EmailRule implements RuleInterface
{
    public function validate($value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    public function getMessage($value): string
    {
        return "The $value is not valid";
    }
}
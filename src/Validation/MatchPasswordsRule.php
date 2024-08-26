<?php

namespace Src\Validation;

class MatchPasswordsRule implements RuleInterface
{
    private string $fistPassword;

    public function __construct(string $fistPassword)
    {
        $this->fistPassword = $fistPassword;
    }

    public function validate($value): bool
    {
        return $value === $this->fistPassword;
    }

    public function getMessage($value): string
    {
        return "The $value  do not match";
    }
}
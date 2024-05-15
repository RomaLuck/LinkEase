<?php

namespace Src\Validation;

class StringLengthRule implements RuleInterface
{
    private int $min;
    private int $max;

    public function __construct(int $min, int $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function validate($value): bool
    {
        $value = trim($value);
        return strlen($value) >= $this->min && strlen($value) <= $this->max;
    }

    public function getMessage($value): string
    {
        return "The $value must contain at least $this->min characters and maximum $this->max characters";
    }
}
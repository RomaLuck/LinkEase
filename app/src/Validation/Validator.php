<?php

namespace Src\Validation;

class Validator
{
    public static function string(string $value, int $min = 1, int $max = INF): bool
    {
        return (new StringLengthRule($min, $max))->validate($value);
    }

    public static function email(string $value): bool
    {
        return (new EmailRule())->validate($value);
    }

    public static function matchPasswords(string $fistPassword, string $secondPassword): bool
    {
        return (new MatchPasswordsRule($fistPassword))->validate($secondPassword);
    }
}
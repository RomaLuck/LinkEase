<?php

use JetBrains\PhpStorm\NoReturn;

#[NoReturn]
function dd($value): void
{
    var_dump($value);
    die();
}

#[NoReturn]
function abort($code): void
{
    http_response_code($code);

    require "views/$code.php";
    die();
}
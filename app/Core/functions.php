<?php

use Core\Response;
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

    view($code . '.php');
    die();
}

function view($path, $attributes = []): void
{
    extract($attributes);

    require "views/$path";
}

function authorize($condition, $status = Response::FORBIDDEN): bool
{
    if (!$condition) {
        abort($status);
    }

    return true;
}
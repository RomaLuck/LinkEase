<?php

namespace Http\Middleware;

use Exception;

require_once "Guest.php";
require_once "Authenticated.php";

class Middleware
{
    public const MAP = [
        'guest' => Guest::class,
        'auth' => Authenticated::class
    ];

    /**
     * @throws Exception
     */
    public static function resolve($key): void
    {
        if (!$key) {
            return;
        }

        $middleware = self::MAP[$key] ?? false;
        if (!$middleware) {
            throw new Exception("No matching middleware found for key '{$key}'.");
        }

        (new $middleware)->handle();
    }
}
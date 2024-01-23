<?php

namespace Core;

class Session
{
    public static function has($key): bool
    {
        return (bool)static::get($key);
    }

    public static function put($key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION['_flash'][$key] ?? $_SESSION[$key] ?? $default;
    }

    public static function getFlashes(): array
    {
        $result = [];
        foreach ($_SESSION['_flash'] ?? [] as $flashKey => $flash) {
            if (is_array($flash)) {
                foreach ($flash as $key => $message) {
                    $result[$key] = $message;
                }
            } else {
                $result[$flashKey] = $flash;
            }
        }

        return $result;
    }

    public static function unset($key): void
    {
        unset($_SESSION[$key]);
    }

    public static function flash($key, $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash(): void
    {
        unset($_SESSION['_flash']);
    }

    public static function flush(): void
    {
        $_SESSION = [];
    }

    public static function destroy(): void
    {
        static::flush();

        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}
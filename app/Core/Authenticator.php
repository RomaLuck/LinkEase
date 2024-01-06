<?php

namespace Core;

class Authenticator
{
    /**
     * @throws \Exception
     */
    public function attempt($email, $password): bool
    {
        $user = App::resolve(Database::class)
            ->query('SELECT * FROM users WHERE email=:email', ['email' => $email])
            ->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $this->login(['email' => $email]);

            return true;
        }

        return false;
    }

    public function login(array $user): void
    {
        $_SESSION['user'] = ['email' => $user['email']];

        session_regenerate_id(true);
    }

    public function logout(): void
    {
        session_destroy();
    }
}
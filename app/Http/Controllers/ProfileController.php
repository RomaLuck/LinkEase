<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class ProfileController extends Controller
{
    public function __invoke(): void
    {
        $userData = App::resolve(Database::class)->query(
            'SELECT * FROM users WHERE email = :email',
            ['email' => $_SESSION['user']['email']]
        )->fetch();

        view('profile.view.php', ['userData' => $userData]);
    }
}
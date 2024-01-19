<?php

namespace Http\Controllers;

use Core\App;
use Core\Database;

class ProfileController extends Controller
{
    public function __invoke(): void
    {
        $errors = [];
        $userData = [];

        try {
            $userData = App::resolve(Database::class)->query(
                'SELECT * FROM users WHERE id = :id',
                [
                    'id' => $_SESSION['user']['id']
                ]
            )->fetch();
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $this->render('profile.view.php', [
            'userData' => $userData,
            'errors' => $errors,
        ]);
    }
}
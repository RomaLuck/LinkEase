<?php

namespace Src\Controllers\profile;

use Src\Controllers\Controller;
use Src\Database;
use Src\Session;

class ProfileController extends Controller
{
    public function __invoke(Database $database): void
    {
        $errors = [];

        try {
            $userData = $database->query(
                'SELECT * FROM users WHERE id = :id',
                [
                    'id' => Session::get('user')['id']
                ]
            )->fetch();
        } catch (\Exception $e) {
            $errors[] = $e->getMessage();
        }

        $this->render('profile.view.php', [
            'userData' => $userData ?? [],
            'errors' => $errors,
        ]);
    }
}
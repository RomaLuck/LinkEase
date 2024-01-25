<?php

namespace Http\Controllers;

use Core\Container;
use Core\Database;
use Core\Session;

class ProfileController extends Controller
{
    public function __invoke(Container $container): void
    {
        $errors = [];

        try {
            $userData = $container->get(Database::class)?->query(
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
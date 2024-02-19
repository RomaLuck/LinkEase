<?php

namespace Http\Controllers\profile;

use Core\Container;
use Core\Database;
use Core\Session;
use Http\Controllers\Controller;

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
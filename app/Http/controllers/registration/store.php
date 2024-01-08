<?php

use Core\App;
use Core\Authenticator;
use Core\Database;

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

/**
 * @var PDO $db
 */
$db = App::resolve(Database::class);
$user = $db->query('select * from users where email = :email', [
    'email' => $email
])->fetch();

if ($user) {
    header('location: /');
    exit();
}

$user = $db->query('INSERT INTO users(email, password) VALUES(:email, :password)', [
    'email' => $email,
    'password' => password_hash($password, PASSWORD_BCRYPT)
]);

(new Authenticator())->login(['email' => $email]);

header('location: /');
exit();



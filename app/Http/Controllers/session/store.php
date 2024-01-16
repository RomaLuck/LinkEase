<?php

use Core\Security\Authenticator;
use Core\Validator;

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

$errors = [];

if (!Validator::email($email)) {
    $errors['email'] = 'Email is not valid';
}

if (!Validator::string($password, 6, 255)) {
    $errors['password'] = 'The password must contain at least 6 characters';
}

$signedIn = (new Authenticator())->authenticate($email, $password);

if (!$signedIn) {
    $errors['signedIn'] = 'No matching account found for that email address and password.';
}

if (!empty($errors)) {
    view('session/create.view.php', ['errors' => $errors]);
    exit();
}

redirect('/');
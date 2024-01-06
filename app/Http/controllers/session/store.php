<?php

use Core\Authenticator;

$email = htmlspecialchars($_POST['email']);
$password = htmlspecialchars($_POST['password']);

$signedIn = (new Authenticator())->attempt($email,$password);

if (!$signedIn) {
    throw new Exception('No matching account found for that email address and password.');
}
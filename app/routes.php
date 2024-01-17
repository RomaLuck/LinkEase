<?php

use Core\Router;
use Http\Controllers\AboutController;
use Http\Controllers\ContactController;
use Http\Controllers\HomeController;
use Http\Controllers\oauth\ConnectActionController;
use Http\Controllers\oauth\ConnectionActionCheckController;
use Http\Controllers\ProfileController;
use Http\Controllers\registration\RegistrationController;
use Http\Controllers\registration\RegistrationViewController;
use Http\Controllers\session\LoginViewController;
use Http\Controllers\session\AuthSessionDestroyController;
use Http\Controllers\session\AuthSessionCreateController;

$router = new Router();

$router->addRoute('GET', '/', new HomeController());
$router->addRoute('GET', '/about', new AboutController());
$router->addRoute('GET', '/contact', new ContactController());
$router->addRoute('GET', '/profile', new ProfileController())->middleware('auth');

$router->addRoute('GET', '/login', new LoginViewController())->middleware('guest');
$router->addRoute('GET', '/logout', new AuthSessionDestroyController());
$router->addRoute('POST', '/session', new AuthSessionCreateController());

$router->addRoute('GET', '/register', new RegistrationViewController())->middleware('guest');
$router->addRoute('POST', '/register', new RegistrationController());

$router->addRoute('GET', '/connect/oauth', new ConnectActionController())->middleware('guest');
$router->addRoute('GET', '/connect/oauth/check', new ConnectionActionCheckController());

$router->matchRoute();
<?php

use Src\Controllers\AboutController;
use Src\Controllers\ContactController;
use Src\Controllers\features\WeatherDataController;
use Src\Controllers\features\WeatherViewController;
use Src\Controllers\HomeController;
use Src\Controllers\profile\oauth\ConnectActionController;
use Src\Controllers\profile\oauth\ConnectionActionCheckController;
use Src\Controllers\profile\ProfileController;
use Src\Controllers\profile\ProfileUpdateController;
use Src\Controllers\profile\registration\ProfileCreateController;
use Src\Controllers\profile\registration\RegistrationViewController;
use Src\Controllers\profile\session\AuthSessionCreateController;
use Src\Controllers\profile\session\AuthSessionDestroyController;
use Src\Controllers\profile\session\LoginViewController;
use Src\Router;

$router = new Router();

$router->addRoute('GET', '/', new HomeController());
$router->addRoute('GET', '/about', new AboutController());
$router->addRoute('GET', '/contact', new ContactController());
$router->addRoute('GET', '/profile', new ProfileController())->middleware('auth');

$router->addRoute('GET', '/login', new LoginViewController())->middleware('guest');
$router->addRoute('DELETE', '/session', new AuthSessionDestroyController());
$router->addRoute('POST', '/session', new AuthSessionCreateController());

$router->addRoute('GET', '/register', new RegistrationViewController())->middleware('guest');
$router->addRoute('POST', '/register', new ProfileCreateController());
$router->addRoute('PATCH', '/profile', new ProfileUpdateController());

$router->addRoute('GET', '/connect/oauth', new ConnectActionController())->middleware('guest');
$router->addRoute('GET', '/connect/oauth/check', new ConnectionActionCheckController());

$router->addRoute('GET', '/weather', new WeatherViewController())->middleware('auth');
$router->addRoute('POST', '/weather', new WeatherDataController())->middleware('auth');

$router->matchRoute();
<?php

use Core\Router;
use Http\Controllers\AboutController;
use Http\Controllers\ContactController;
use Http\Controllers\HomeController;
use Http\Controllers\oauth\ConnectActionController;
use Http\Controllers\oauth\ConnectionActionCheckController;
use Http\Controllers\ProfileController;
use Http\Controllers\ProfileUpdateController;
use Http\Controllers\registration\ProfileCreateController;
use Http\Controllers\registration\RegistrationViewController;
use Http\Controllers\session\AuthSessionCreateController;
use Http\Controllers\session\AuthSessionDestroyController;
use Http\Controllers\session\LoginViewController;
use Http\Controllers\WeatherDataController;
use Http\Controllers\WeatherViewController;

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
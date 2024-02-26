<?php

use Src\Http\About\AboutController;
use Src\Http\Contact\ContactController;
use Src\Http\Features\WeatherDataController;
use Src\Http\Features\WeatherViewController;
use Src\Http\HomeController;
use Src\Http\Profile\Oauth\ConnectActionController;
use Src\Http\Profile\Oauth\ConnectionActionCheckController;
use Src\Http\Profile\ProfileController;
use Src\Http\Profile\ProfileUpdateController;
use Src\Http\Profile\Registration\ProfileCreateController;
use Src\Http\Profile\Registration\RegistrationViewController;
use Src\Http\Profile\Session\AuthSessionCreateController;
use Src\Http\Profile\Session\AuthSessionDestroyController;
use Src\Http\Profile\Session\LoginViewController;
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
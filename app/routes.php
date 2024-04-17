<?php

use Src\Http\About\AboutController;
use Src\Http\Contact\ContactController;
use Src\Http\Features\Study\StudyDataController;
use Src\Http\Features\Study\StudyViewController;
use Src\Http\Features\Weather\WeatherDataController;
use Src\Http\Features\Weather\WeatherViewController;
use Src\Http\HomeController;
use Src\Http\Profile\Oauth\ConnectActionController;
use Src\Http\Profile\Oauth\ConnectionActionCheckController;
use Src\Http\Profile\ProfileController;
use Src\Http\Profile\ProfileUpdateController;
use Src\Http\Profile\Registration\EmailConfirmationController;
use Src\Http\Profile\Registration\ProfileCreateController;
use Src\Http\Profile\Registration\RegistrationViewController;
use Src\Http\Profile\Session\AuthSessionCreateController;
use Src\Http\Profile\Session\AuthSessionDestroyController;
use Src\Http\Profile\Session\LoginViewController;
use Src\Router;

$router = new Router();

$router->addRoute('GET', '/', HomeController::class);
$router->addRoute('GET', '/about', AboutController::class);
$router->addRoute('GET', '/contact', ContactController::class);
$router->addRoute('GET', '/profile', ProfileController::class)->middleware('auth');

$router->addRoute('GET', '/login', LoginViewController::class)->middleware('guest');
$router->addRoute('DELETE', '/session', AuthSessionDestroyController::class);
$router->addRoute('POST', '/session', AuthSessionCreateController::class);

$router->addRoute('GET', '/register', RegistrationViewController::class)->middleware('guest');
$router->addRoute('POST', '/register', ProfileCreateController::class);
$router->addRoute('PATCH', '/profile', ProfileUpdateController::class);

$router->addRoute('GET', '/connect/oauth', ConnectActionController::class)->middleware('guest');
$router->addRoute('GET', '/connect/oauth/check', ConnectionActionCheckController::class);

$router->addRoute('GET', '/weather', WeatherViewController::class)->middleware('auth');
$router->addRoute('POST', '/weather', WeatherDataController::class)->middleware('auth');

$router->addRoute('GET', '/study', StudyViewController::class)->middleware('auth');
$router->addRoute('POST', '/study', StudyDataController::class)->middleware('auth');

$router->addRoute('GET', '/confirm-email', EmailConfirmationController::class);

$router->matchRoute()->send();
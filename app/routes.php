<?php

use Src\Http\About\AboutController;
use Src\Http\Contact\ContactController;
use Src\Http\Contact\ContactFormController;
use Src\Http\Errors\InternalServerErrorController;
use Src\Http\Errors\PageForbiddenController;
use Src\Http\Errors\PageNotFoundController;
use Src\Http\Errors\UnauthorizedUserController;
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
use Src\Http\Profile\Registration\RegistrationController;
use Src\Http\Profile\Registration\RegistrationViewController;
use Src\Http\Profile\Session\LogInController;
use Src\Http\Profile\Session\LogOutController;
use Src\Http\Profile\Session\LoginViewController;
use Src\Router;

$router = new Router();

$router->addRoute('GET', '/', HomeController::class);
$router->addRoute('GET', '/about', AboutController::class);
$router->addRoute('GET', '/contact', ContactFormController::class);
$router->addRoute('POST', '/contact', ContactController::class);
$router->addRoute('GET', '/profile', ProfileController::class)->middleware('auth');

$router->addRoute('GET', '/login', LoginViewController::class)->middleware('guest');
$router->addRoute('DELETE', '/session', LogOutController::class);
$router->addRoute('POST', '/session', LogInController::class);

$router->addRoute('GET', '/register', RegistrationViewController::class)->middleware('guest');
$router->addRoute('POST', '/register', RegistrationController::class);
$router->addRoute('PATCH', '/profile', ProfileUpdateController::class);

$router->addRoute('GET', '/connect/oauth', ConnectActionController::class)->middleware('guest');
$router->addRoute('GET', '/connect/oauth/check', ConnectionActionCheckController::class);

$router->addRoute('GET', '/weather', WeatherViewController::class)->middleware('auth');
$router->addRoute('POST', '/weather', WeatherDataController::class)->middleware('auth');

$router->addRoute('GET', '/study', StudyViewController::class)->middleware('auth');
$router->addRoute('POST', '/study', StudyDataController::class)->middleware('auth');

$router->addRoute('GET', '/confirm-email', EmailConfirmationController::class);

$router->addRoute('GET', '/404', PageNotFoundController::class);
$router->addRoute('GET', '/403', PageForbiddenController::class);
$router->addRoute('GET', '/401', UnauthorizedUserController::class);
$router->addRoute('GET', '/500', InternalServerErrorController::class);

$router->matchRoute()->send();
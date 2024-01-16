<?php

use Core\Middleware\AuthMiddleware;
use Core\Router;
use Http\Controllers\ProfileController;

$router = new Router();

$router->addRoute('GET', '/', function () {
    require "Http/Controllers/index.php";
});
$router->addRoute('GET', '/about', function () {
    require "Http/Controllers/about.php";
});
$router->addRoute('GET', '/contact', function () {
    require "Http/Controllers/contact.php";
});
$router->addRoute('GET', '/profile', new ProfileController())->middleware('auth');
$router->addRoute('GET', '/login', function () {
    AuthMiddleware::resolve('guest');
    require "Http/Controllers/session/create.php";
});
$router->addRoute('GET', '/logout', function () {
    require "Http/Controllers/session/destroy.php";
});
$router->addRoute('POST', '/session', function () {
    require "Http/Controllers/session/store.php";
});
$router->addRoute('GET', '/register', function () {
    AuthMiddleware::resolve('guest');
    require "Http/Controllers/registration/create.php";
});
$router->addRoute('POST', '/register', function () {
    require "Http/Controllers/registration/store.php";
});
$router->addRoute('GET', '/connect/:provider', function ($provider) {
    AuthMiddleware::resolve('guest');
    require "Http/Controllers/oauth/create.php";
});
$router->addRoute('GET', '/connect/google/check/:query', function ($query) {
    require "Http/Controllers/oauth/store.php";
});

$router->matchRoute();
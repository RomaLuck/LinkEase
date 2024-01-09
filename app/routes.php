<?php

use Core\Middleware\AuthMiddleware;
use Core\Router;

$router = new Router();

$router->addRoute('GET', '/', function () {
    require "Http/controllers/index.php";
});
$router->addRoute('GET', '/about', function () {
    require "Http/controllers/about.php";
});
$router->addRoute('GET', '/contact', function () {
    require "Http/controllers/contact.php";
});
$router->addRoute('GET', '/profile', function () {
    AuthMiddleware::resolve('auth');
    require "Http/controllers/profile.php";
});
$router->addRoute('GET', '/login', function () {
    AuthMiddleware::resolve('guest');
    require "Http/controllers/session/create.php";
});
$router->addRoute('GET', '/logout', function () {
    require "Http/controllers/session/destroy.php";
});
$router->addRoute('POST', '/session', function () {
    require "Http/controllers/session/store.php";
});
$router->addRoute('GET', '/register', function () {
    AuthMiddleware::resolve('guest');
    require "Http/controllers/registration/create.php";
});
$router->addRoute('POST', '/register', function () {
    require "Http/controllers/registration/store.php";
});

$router->matchRoute();
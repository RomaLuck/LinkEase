<?php

use Core\Router;
use Http\Middleware\Middleware;

require_once "Core/Router.php";
require_once "Http/Middleware/Middleware.php";

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
    Middleware::resolve('auth');
    require "Http/controllers/profile.php";
});
$router->addRoute('GET', '/login', function () {
//    Middleware::resolve('guest');
    require "Http/controllers/session/create.php";
});
$router->addRoute('GET', '/register', function () {
//    Middleware::resolve('guest');
    require "Http/controllers/registration/create.php";
});

$router->matchRoute();
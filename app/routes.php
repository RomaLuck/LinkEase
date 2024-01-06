<?php

use Core\Router;

require_once "Core/Router.php";

$router = new Router();

$router->addRoute('GET', '/', function () {
    require "controllers/index.php";
});
$router->addRoute('GET', '/about', function () {
    require "controllers/about.php";
});
$router->addRoute('GET', '/contact', function () {
    require "controllers/contact.php";
});

$router->matchRoute();
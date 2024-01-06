<?php

use Core\App;
use Core\Container;
use Core\Database;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$container = new Container();
$container->bind(Database::class, function () {
    return new Database($_ENV['DATABASE_URL'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
});

App::setContainer($container);
<?php


//session_start();

use Symfony\Component\HttpFoundation\Session\Session;

require_once "vendor/autoload.php";

$session = new Session;
$session->start();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

require_once "routes.php";

//$session->clear();
<?php

use Core\Session;

session_start();

require_once "vendor/autoload.php";
require_once "Core/functions.php";
require_once "bootstrap.php";
require_once "routes.php";

Session::unflash();
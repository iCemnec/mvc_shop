<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/routes/routes.php';

$session = new \App\Components\Session();
//$db = new \App\Components\DbInstall();

$router->dispatch($_SERVER['REQUEST_URI']);

new \App\Components\ErrorHandler();



<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/routes/routes.php';


$router->dispatch($_SERVER['REQUEST_URI']);
//
//try {
//    $logger = new \App\Components\MonoLogger("Main");
//    $logger->pushHandler(new \Monolog\Handler\StreamHandler(DIR_LOG . 'mono-log-' . date('Y-m-d') . '.txt',
//        \App\Components\MonoLogger::DEBUG));
//} catch (Exception $e) {
//    new \App\Components\MonoLogger("Index");
//}

//$logger->debug('First message');

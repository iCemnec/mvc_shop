<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/routes/routes.php';

$router->dispatch($_SERVER['REQUEST_URI']);

new \App\Components\ErrorHandler();


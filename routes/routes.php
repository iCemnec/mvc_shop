<?php

use Core\Router;

$router = new Router();

$router->add('products', ['controller' => 'ProductController', 'action' => 'index']);
$router->add('login', ['controller' => 'LoginController', 'action' => 'index']);
$router->add('login/welcome', ['controller' => 'LoginController', 'action' => 'show']);
$router->add('', ['controller' => 'HomeController', 'action' => 'index']);

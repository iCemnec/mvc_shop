<?php

use Core\Router;

$router = new Router();

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('catalog', ['controller' => 'BookController', 'action' => 'index']);
$router->add('genre/{id:\d+}', ['controller' => 'BookController', 'action' => 'showGenre']);

$router->add('login', ['controller' => 'LoginController', 'action' => 'index']);
$router->add('login/welcome', ['controller' => 'LoginController', 'action' => 'show']);

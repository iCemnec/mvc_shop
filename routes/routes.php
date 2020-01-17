<?php

use Core\Router;

$router = new Router();

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('catalog', ['controller' => 'BookController', 'action' => 'index']);
$router->add('catalog/{id:\d+}', ['controller' => 'GenreController', 'action' => 'show']);
$router->add('book/{id:\d+}', ['controller' => 'BookController', 'action' => 'show']);
$router->add('author/{id:\d+}', ['controller' => 'AuthorController', 'action' => 'show']);

$router->add('login', ['controller' => 'LoginController', 'action' => 'index']);
$router->add('login/welcome', ['controller' => 'LoginController', 'action' => 'show']);

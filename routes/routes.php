<?php

use Core\Router;

$router = new Router();

$router->add('', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('catalog', ['controller' => 'BookController', 'action' => 'index']);
$router->add('catalog/{id:\d+}', ['controller' => 'GenreController', 'action' => 'show']);
$router->add('book/{id:\d+}', ['controller' => 'BookController', 'action' => 'show']);
$router->add('author/{id:\d+}', ['controller' => 'AuthorController', 'action' => 'show']);

$router->add('cart', ['controller' => 'CartController', 'action' => 'index']);

//user
$router->add('user/store', ['controller' => 'UserController', 'action' => 'store']);
$router->add('user/login', ['controller' => 'UserController', 'action' => 'login']);
$router->add('user/logout', ['controller' => 'UserController', 'action' => 'logout']);
$router->add('user/{id:\d+}', ['controller' => 'UserController', 'action' => 'show']);
$router->add('user/{id:\d+}/edit', ['controller' => 'UserController', 'action' => 'edit']);
$router->add('user/{id:\d+}/update', ['controller' => 'UserController', 'action' => 'update']);

//admin
$router->add('admin', ['controller' => 'admin\AdminController', 'action' => 'index']);

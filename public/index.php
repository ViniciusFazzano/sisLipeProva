<?php
require '../src/Router.php';
require '../src/Controller/LoginController.php';
require '../src/Controller/AccountController.php';

$router = new Router();
$router->addRoute('/login', LoginController::class, 'index');
$router->addRoute('/create-account', AccountController::class, 'create');

$router->run();

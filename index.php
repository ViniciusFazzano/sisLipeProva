<?php

require_once 'src/Router.php';
require_once 'src/Controller/LoginController.php';
require_once 'src/Controller/AccountController.php';

$router = new Router();
$router->addRoute('/login', LoginController::class, 'index');
$router->addRoute('/create-account', AccountController::class, 'create');

$router->run();

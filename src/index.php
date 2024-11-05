<?php

use Controller\AccountController;
use Controller\LoginController;
use Router\Router;

require_once 'vendor/autoload.php';

$router = new Router();
$router->addRoute('/login', LoginController::class, 'index', 'GET'); // Rota GET
$router->addRoute('/create-account', AccountController::class, 'create', 'POST'); // Rota POST

$router->addRoute('/account/:id', AccountController::class, 'show', 'GET');

$router->run();

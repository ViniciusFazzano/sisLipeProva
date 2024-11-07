<?php

use Controller\AccountController;
use Controller\HomeopatiaCalculator;
use Controller\LoginController;
use Router\Router;

require_once 'vendor/autoload.php';

$router = new Router();
$router->addRoute('/login', LoginController::class, 'index', 'GET');
$router->addRoute('/novo-login', AccountController::class, 'create', 'POST');
$router->addRoute('/novo-login', AccountController::class, 'update', 'PUT');
$router->addRoute('/novo-login', AccountController::class, 'delete', 'DELETE');

$router->addRoute('/calculo', HomeopatiaCalculator::class, 'calcular', 'POST');
$router->addRoute('/calculo/:id', HomeopatiaCalculator::class, 'update', 'PUT');
$router->addRoute('/calculo/:id', HomeopatiaCalculator::class, 'delete', 'DELETE');
$router->addRoute('/calculo', HomeopatiaCalculator::class, 'getList', 'GET');
$router->addRoute('/calculo/:id', HomeopatiaCalculator::class, 'getId', 'GET');

$router->addRoute('/account/:id', AccountController::class, 'show', 'GET');

$router->run();

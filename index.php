<?php
use Src\Controller\LoginController;

require_once 'vendor/autoload.php';

$router = new Router();
$router->addRoute('/login', LoginController::class, 'index');
$router->addRoute('/create-account', AccountController::class, 'create');

$router->run();

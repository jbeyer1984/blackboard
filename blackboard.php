<?php

// daten verarbeiten
use src\Core\DI\Service;
use src\Router\_Router;
use src\Router\Router;

include(__DIR__ . '/src/Bootstrap.php');
//$blackboard = new Blackboard();


$routerService = Service::get(_Router::class);
$router = $routerService->getSingle(Router::class);
$router->route();
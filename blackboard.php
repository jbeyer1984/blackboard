<?php

// daten verarbeiten
use src\Router\Factory\RouterFactory;

include(__DIR__ . '/src/Bootstrap.php');

//$routerService = Service::get(_Router::class);
//$router = $routerService->getSingle(Router::class);
//$router->route();

$routerFactory = new RouterFactory();
$router = $routerFactory->getCreated();
$router->route();
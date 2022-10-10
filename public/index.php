<?php
require_once '../vendor/autoload.php';

use app\controllers\ProductsController;
use app\Router;

$router = new Router();

$router->get('/',[ProductsController::class, 'index']);

$router->post('/products/create',[ProductsController::class, 'create']);
$router->get('/products/create',[ProductsController::class, 'create']);

$router->post('/products/update',[ProductsController::class, 'update']);
$router->get('/products/update',[ProductsController::class, 'update']);

$router->post('/products/delete',[ProductsController::class, 'delete']);

$router->resolve();

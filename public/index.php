<?php

use app\controllers\UserController;
use app\controllers\TaskController;
use app\core\Application;

require_once __DIR__ . '/../vendor/autoload.php';

$config = [
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=custom_mvc',
        'user' => 'root',
        'password' => '',
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [TaskController::class, 'index']);
$app->router->get('/create',  [TaskController::class, 'create']);
$app->router->post('/store',  [TaskController::class, 'store']);
$app->router->get('/edit',  [TaskController::class, 'edit']);
$app->router->post('/update',  [TaskController::class, 'update']);
$app->router->get('/login',  [UserController::class, 'login']);
$app->router->post('/login',  [UserController::class, 'login']);
$app->router->get('/logout',  [UserController::class, 'logout']);

$app->run();
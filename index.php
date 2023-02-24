<?php
session_start();
require_once "vendor/autoload.php";


$app = new \App\Application();

$app->router->get('/' , [\App\Controller\HomeController::class , 'index']);
$app->router->get('/home' , [\App\Controller\HomeController::class , 'index']);
$app->router->get('/register' , [\App\Controller\RegisterController::class , 'index']);
$app->router->get('/login' , [\App\Controller\LoginController::class , 'index']);
$app->router->post('/register' , [\App\Controller\RegisterController::class , 'store']);
$app->router->post('/login' , [\App\Controller\LoginController::class , 'store']);
$app->router->post('/logout' , [\App\Controller\LoginController::class , 'logout']);
$app->router->get('/tasks' , [\App\Controller\TasksController::class , 'index']);
$app->router->post('/tasks' , [\App\Controller\TasksController::class , 'store']);
$app->router->post('/tasks/update' , [\App\Controller\TasksController::class , 'update']);

$app->run();

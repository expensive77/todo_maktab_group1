<?php

namespace App\Controller;

use App\Application;

class HomeController
{
    public function index(){
        if (!isset($_SESSION['user_id']) && !isset($_COOKIE['user_id'])){
            header('Location: login');
        }
        return Application::$app->router->renderView('home');
    }
}
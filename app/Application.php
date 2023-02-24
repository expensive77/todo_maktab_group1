<?php

namespace App;

class Application
{
    public Router $router;
    public Controller $controller;
    public static Application $app;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        self::$app = $this;
        $this->router = new Router($this->request);
        $this->controller = new Controller();
    }

    public function run(){
        $this->router->resolve();
    }
}
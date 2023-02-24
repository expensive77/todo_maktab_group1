<?php

namespace App;

class Application
{
    public Router $router;
    public static Application $app;
    public Request $request;

    public function __construct()
    {
        $this->request = new Request();
        self::$app = $this;
        $this->router = new Router($this->request);
    }

    public function run(){
        $this->router->resolve();
    }
}
<?php

require_once __DIR__ . '/Router.php';

class Miranda
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    public function router(): Router
    {
        return $this->router;
    }

    public function run()
    {
        $this->router->dispatch(
            $_SERVER['REQUEST_URI'],
            $_SERVER['REQUEST_METHOD']
        );
    }
}
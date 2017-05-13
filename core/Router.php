<?php namespace kiwi;

class Router
{
    protected $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function delegate()
    {
        if (array_key_exists(
            Request::uri(),
            $this->routes[Request::method()]
        )) {
            return $this->fire(
                   ...explode('@', $this->routes[Request::method()][Request::uri])
               );
        }
        throw new Exception('Route not defined.');
    }

    protected function fire($controller, $method)
    {
        $controller = new $controller;
        if (! method_exists($controller, $method)) {
            throw new Exception(
                   "{$method} doesn't exist in {$controller}."
               );
        }
        return $controller->$method();
    }

    public static function loadRoutes($file)
    {
        $router = new static;
        require $file;
        return $router;
    }
}

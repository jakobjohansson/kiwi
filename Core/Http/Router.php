<?php

namespace kiwi\Http;

use kiwi\Error\HttpException;

class Router
{
    /**
     * The registered routes.
     *
     * @var array
     */
    protected $routes = [
        'GET'  => [],
        'POST' => [],
    ];

    /**
     * Register a GET route.
     *
     * @param string $path
     * @param string $handler
     *
     * @return void
     */
    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    /**
     * Register a POST route.
     *
     * @param string $path
     * @param string $handler
     *
     * @return void
     */
    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    /**
     * Check if the route is registered.
     * If so, delegate to the fire() method.
     *
     * @return $this->fire
     */
    public function delegate()
    {
        if (array_key_exists(Request::uri(), $this->routes[Request::method()])) {
            $action = $this->routes[Request::method()][Request::uri()];

            if (is_callable($action)) {
                return $action();
            }

            return $this->fire(...explode('/', $action));
        }

        throw new HttpException('Route not defined.');
    }

    /**
     * Fire a controller method.
     *
     * @param string $controller
     * @param string $method
     *
     * @return Controller/method
     */
    protected function fire($controller, $method)
    {
        $controller = "\\kiwi\\Http\\{$controller}";
        $controller = new $controller();

        if (!method_exists($controller, $method)) {
            throw new HttpException(
                "The {$method} method doesn't exist."
            );
        }

        return $controller->$method();
    }

    /**
     * Load a routes file and new up the Router.
     *
     * @param string $file
     *
     * @return Router
     */
    public static function loadRoutes($file)
    {
        $router = new self();

        require $file;

        $router->registerAdminRoutes();

        $router->registerAuthRoutes();

        return $router;
    }

    /**
     * Register admin routes here instead of bloating the routes file.
     *
     * @return void
     */
    public function registerAdminRoutes()
    {
        $this->get('admin', 'AdminController/index');
        $this->get('admin/write', 'AdminController/create');
        $this->post('admin/write', 'AdminController/store');
        $this->get('admin/delete/{id}', 'AdminController/delete');
    }

    /**
     * Register auth routes.
     *
     * @return void
     */
    public function registerAuthRoutes()
    {
        $this->get('login', 'AuthController/login');
        $this->post('login', 'AuthController/attempt');
        $this->get('logout', 'AuthController/logout');
    }
}

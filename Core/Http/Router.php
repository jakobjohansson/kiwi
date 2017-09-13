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

        $this->checkWildcards();

        throw new HttpException('Route not defined.');
    }

    /**
     * If no static routes are hitting, check for wildcards.
     *
     * @return $this->fire
     */
    private function checkWildcards()
    {
        // check for regexp matches
        foreach ($this->routes[Request::method()] as $route => $action) {
            if (is_callable($action)) {
                continue;
            }

            if (!$pos = strpos($route, '{')) {
                continue;
            }

            $clean = substr($route, 0, $pos);
            if (strpos(Request::uri(), $clean) === false) {
                continue;
            }

            $actual = substr(Request::uri(), strpos(Request::uri(), $clean));

            $parameter = str_replace($clean, '', $actual);

            // fire $action($parameter)
            //dd($clean, $route, $actual, $parameter);

            $controller = explode('/', $action)[0];
            $method = explode('/', $action)[1];

            return $this->fire($controller, $method, $parameter);
        }
    }

    /**
     * Fire a controller method.
     *
     * @param string $controller
     * @param string $method
     *
     * @return Controller/method
     */
    protected function fire($controller, $method, $parameters = null)
    {
        $controller = "\\kiwi\\Http\\{$controller}";
        $controller = new $controller();

        if (!method_exists($controller, $method)) {
            throw new HttpException(
                "The {$method} method doesn't exist."
            );
        }

        return $controller->$method($parameters);
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
        $this->get('admin/delete/{id}', 'AdminController/destroy');
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

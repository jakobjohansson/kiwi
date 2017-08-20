<?php

namespace kiwi\Http;

use kiwi\System\Filesystem;

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
     * @param string $path    the URI to the route
     * @param string $handler the controller/method handler
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
     * @param string $path    the URI to the route
     * @param string $handler the controller/method handler
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
     * @return Router/Fire
     */
    public function delegate()
    {
        if (array_key_exists(
            Request::uri(),
            $this->routes[Request::method()]
        )) {
            return $this->fire(
                ...explode(
                    '/',
                    $this->routes[Request::method()][Request::uri()]
                )
            );
        }

        throw new Exception('Route not defined.');
    }

    /**
     * Fire a controller method.
     *
     * @param string $controller the name of the controller
     * @param string $method     the name of the method
     *
     * @return Controller/method
     */
    protected function fire($controller, $method)
    {
        $controller = "\\kiwi\\Http\\{$controller}";
        $controller = new $controller();
        if (!method_exists($controller, $method)) {
            throw new Exception(
                "The {$method} method doesn't exist."
            );
        }

        return $controller->$method();
    }

    /**
     * Load a routes file and new up the Router.
     *
     * @param string $file the Routes file
     *
     * @return Router
     */
    public static function loadRoutes($file)
    {
        $router = new static();
        if (Filesystem::find('Install' . DIRECTORY_SEPARATOR . 'routes.php')) {
            $file = 'Install' . DIRECTORY_SEPARATOR . 'routes.php';
        }
        require $file;

        return $router;
    }
}

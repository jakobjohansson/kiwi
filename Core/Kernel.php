<?php

namespace kiwi;

use kiwi\Database\Connection;
use kiwi\Error\ErrorHandler;
use kiwi\Http\Router;

class Kernel
{
    /**
     * Construct a new Kernel instance.
     */
    public function __construct()
    {
        $this->boot();
    }

    /**
     * Check for files and boot the kernel.
     *
     * @return void
     */
    private function boot()
    {
        // TODO: initiate loader here.

        $this->bindDefaultDependencies();
    }

    /**
     * Run the router and handle the request.
     *
     * @return void
     */
    public function run()
    {
        try {
            Router::loadRoutes(
                'App'.DIRECTORY_SEPARATOR.'routes.php'
            )->delegate();
        } catch (\Exception $e) {
            return ErrorHandler::render($e);
        }
    }

    /**
     * Bind the needed dependencies to the container.
     *
     * @return void
     */
    private function bindDefaultDependencies()
    {
        // TODO: bind from .env
        Container::bind('connection', Connection::make(require 'App'.DIRECTORY_SEPARATOR.'config.php'));

        Container::bind('app', new Application());
    }
}

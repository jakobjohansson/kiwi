<?php

namespace kiwi;

use kiwi\Database\Connection;
use kiwi\Database\Builder;
use kiwi\Error\ErrorHandler;
use kiwi\Http\Router;
use kiwi\System\Filesystem;

class Kernel
{
    /**
     * Construct a new Kernel instance.
     */
    public function __construct()
    {
        $this->boot();
        $this->bindDefaultDependencies();
    }

    /**
     * Check for files and boot the kernel.
     *
     * @return void
     */
    private function boot()
    {
        if (!Filesystem::find('App'.DIRECTORY_SEPARATOR.'config.php')) {
            throw new Error\RuntimeException('Config file not found.');
        }
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
            return ErrorHandler::renderErrorView($e);
        }
    }

    /**
     * Bind the needed dependencies to the container.
     *
     * @return void
     */
    private function bindDefaultDependencies()
    {
        Container::bind('connection', Connection::make(require 'App'.DIRECTORY_SEPARATOR.'config.php'));

        Container::bind('app', new Application());
    }
}

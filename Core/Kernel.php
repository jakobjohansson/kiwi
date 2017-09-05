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
}

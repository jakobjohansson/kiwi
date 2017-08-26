<?php

namespace kiwi;

use kiwi\Database\Connection;
use kiwi\Database\Model;
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
    }

    /**
     * Check for files and boot the kernel.
     * @return void
     */
    public function boot()
    {
        if (!Filesystem::find('App'.DIRECTORY_SEPARATOR.'config.php')) {
            return;
        }

        Model::boot(
            Connection::make(
                require 'App'.DIRECTORY_SEPARATOR.'config.php'
            )
        );
    }

    /**
     * Run the router and handle the request.
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
}

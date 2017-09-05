<?php

namespace kiwi;

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

        try {
            Router::loadRoutes(
                'App'.DIRECTORY_SEPARATOR.'routes.php'
            )->delegate();
        } catch (\Throwable $e) {
            ErrorHandler::render($e);
        }
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
     * Fancy constructor.
     *
     * @return Kernel
     */
    public static function run()
    {
        return new static();
    }
}

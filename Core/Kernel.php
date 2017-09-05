<?php

namespace kiwi;

use kiwi\Error\ErrorHandler;
use kiwi\System\Loader;
use kiwi\Http\Router;

class Kernel
{
    /**
     * Fancy constructor.
     *
     * @return Kernel
     */
    public static function run()
    {
        Loader::run();

        try {
            Router::loadRoutes(
                'App'.DIRECTORY_SEPARATOR.'routes.php'
            )->delegate();
        } catch (\Throwable $e) {
            ErrorHandler::render($e);
        }
    }
}

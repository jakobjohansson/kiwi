<?php

namespace kiwi;

use kiwi\Error\ErrorHandler;
use kiwi\Http\Router;
use kiwi\System\Loader;

class Kernel
{
    /**
     * Fancy constructor.
     *
     * @return Kernel
     */
    public static function run()
    {
        try {
            Loader::run();

            Router::loadRoutes(
                'App'.DIRECTORY_SEPARATOR.'routes.php'
            )->delegate();
        } catch (\Throwable $e) {
            ErrorHandler::render($e);
        }
    }
}

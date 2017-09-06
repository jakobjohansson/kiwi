<?php

namespace kiwi;

use kiwi\Error\ErrorHandler;
use kiwi\Http\Router;
use kiwi\System\Loader;
use kiwi\Database\Connection;

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
            static::loadEnvironment();

            Router::loadRoutes(
                'App'.DIRECTORY_SEPARATOR.'routes.php'
            )->delegate();
        } catch (\Throwable $e) {
            ErrorHandler::render($e);
        }
    }

    public static function loadEnvironment()
    {
        Loader::run();

        Container::bind('connection', Connection::make([
            'host' => getenv('DATABASE_HOST'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASS'),
            'name' => getenv('DATABASE_NAME')
        ]));
    }
}

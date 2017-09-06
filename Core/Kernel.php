<?php

namespace kiwi;

use kiwi\Database\Connection;
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
            static::loadEnvironment();

            Router::loadRoutes(
                'App'.DIRECTORY_SEPARATOR.'routes.php'
            )->delegate();
        } catch (\Throwable $e) {
            ErrorHandler::render($e);
        }
    }

    /**
     * Load the environment variables.
     *
     * @return void
     */
    public static function loadEnvironment()
    {
        Loader::run();

        Container::bind('connection', Connection::make([
            'host'     => getenv('DATABASE_HOST'),
            'username' => getenv('DATABASE_USER'),
            'password' => getenv('DATABASE_PASS'),
            'name'     => getenv('DATABASE_NAME'),
        ]));

        Container::bind('app', new Application(getenv('APP_NAME'), getenv('APP_DESCRIPTION')));
    }
}

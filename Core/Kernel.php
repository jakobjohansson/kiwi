<?php

namespace kiwi;

use kiwi\Database\Connection;
use kiwi\Error\ErrorHandler;
use kiwi\Http\Router;
use kiwi\Http\Session;
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
            'host'     => env('DATABASE_HOST'),
            'username' => env('DATABASE_USER'),
            'password' => env('DATABASE_PASS'),
            'name'     => env('DATABASE_NAME'),
        ]));

        Container::bind('app', new Application(env('APP_NAME'), env('APP_DESCRIPTION'), new Auth(Session::make())));
    }
}

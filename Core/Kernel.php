<?php

namespace kiwi;

use kiwi\Http\Router;
use kiwi\Http\Session;
use kiwi\System\Loader;
use kiwi\Error\ErrorHandler;
use kiwi\Http\ValidationBag;
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
            self::loadDependencies();

            Router::loadRoutes(
                'App' . DIRECTORY_SEPARATOR . 'routes.php'
            )->delegate();
        } catch (\Throwable $e) {
            ErrorHandler::render($e);
        }
    }

    /**
     * Load the environment configuration and dependencies.
     *
     * @return void
     */
    public static function loadDependencies()
    {
        Loader::run();

        bind('session', Session::make());
        bind('bag', new ValidationBag());

        bind('connection', Connection::make([
            'host'     => env('DATABASE_HOST'),
            'username' => env('DATABASE_USER'),
            'password' => env('DATABASE_PASS'),
            'name'     => env('DATABASE_NAME'),
        ]));

        bind('app', new Application(
            env('APP_NAME'),
            env('APP_DESCRIPTION'),
            new Auth(resolve('session'))
        ));
    }
}

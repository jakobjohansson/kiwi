<?php

namespace kiwi;

use kiwi\Http\Router;
use kiwi\Filesystem\Loader;
use kiwi\Error\ErrorHandler;

class Kernel
{
    /**
     * Fancy constructor.
     *
     *  @return void
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

        Container::bindArray([
            'connection' => Database\Connection::class,
            'session'    => Authentication\Session::class,
            'bag'        => Http\ValidationBag::class,
            'auth'       => Auth::class,
            'app'        => Application::class
        ]);
    }
}

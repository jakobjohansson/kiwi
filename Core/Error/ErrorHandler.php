<?php

namespace kiwi\Error;

use kiwi\Container;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $e
     */
    public static function renderErrorView(\Exception $e)
    {
        $app = Container::resolve('app');

        $customErrorFile = 'App'.DIRECTORY_SEPARATOR.'Themes'.DIRECTORY_SEPARATOR.$app->theme.DIRECTORY_SEPARATOR.'error.view.php';

        if (file_exists($customErrorFile)) {
            return require $customErrorFile;
        }

        return require 'App'.DIRECTORY_SEPARATOR.'Themes'.DIRECTORY_SEPARATOR.'kiwi17'.DIRECTORY_SEPARATOR.'error.view.php';
    }
}

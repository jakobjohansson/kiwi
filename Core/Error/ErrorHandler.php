<?php

namespace kiwi\Error;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $exception
     */
    public static function renderErrorView(\Exception $exception)
    {
        $customErrorFile = 'App'.DIRECTORY_SEPARATOR.'Themes'.DIRECTORY_SEPARATOR.Meta::get('theme').DIRECTORY_SEPARATOR.'error.view.php';

        if (file_exists($customErrorFile)) {
            return require $customErrorFile;
        }

        return require 'App'.DIRECTORY_SEPARATOR.'Themes'.DIRECTORY_SEPARATOR.'kiwi17'.DIRECTORY_SEPARATOR.'error.view.php';
    }
}

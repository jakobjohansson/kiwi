<?php

namespace kiwi;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $exception
     */
    public static function renderErrorView(\Exception $exception)
    {
        $customErrorFile = 'themes/'.Meta::get('theme').'/error.view.php';

        if (file_exists($customErrorFile)) {
            return require $customErrorFile;
        }

        return require 'themes/kiwi17/error.view.php';
    }
}

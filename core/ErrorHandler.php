<?php

namespace kiwi;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $exception
     * @param Query     $query
     */
    public static function renderErrorView(Exception $exception, Query $query = null)
    {
        if ($query) {
            $customErrorFile = 'themes/'.Config::get('theme', $query).'/error.view.php';

            if (file_exists($customErrorFile)) {
                return require $customErrorFile;
            }
        }

        return require 'themes/kiwi-default/error.view.php';
    }
}

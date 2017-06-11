<?php

namespace kiwi;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $e
     */
    public static function renderErrorView(Exception $e, Query $query)
    {
        $customErrorFile = 'themes/'.Config::get('theme', $query).'/404.view.php';

        if (file_exists($customErrorFile)) {
            return require $customErrorFile;
        }

        return require 'themes/kiwi-default/404.view.php';
    }
}

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
    public static function renderErrorView(\Exception $exception, Query $query = null)
    {
        // TODO: Remove the need to pass along Query.
        if ($query) {
            $customErrorFile = 'themes/'.Meta::get('theme', $query).'/error.view.php';

            if (file_exists($customErrorFile)) {
                return require $customErrorFile;
            }
        }

        return require 'themes/kiwi17/error.view.php';
    }
}

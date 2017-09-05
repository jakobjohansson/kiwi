<?php

namespace kiwi\Error;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $e
     */
    public static function renderView(\Exception $e)
    {
         require 'App'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'error.view.php';
    }
}

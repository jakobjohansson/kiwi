<?php

namespace kiwi\Error;

use kiwi\Http\View;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param Exception $e
     */
    public static function render(\Throwable $e)
    {
        View::render('error', compact('e'));
    }
}

<?php

namespace kiwi\Error;

use kiwi\Http\View;

class ErrorHandler
{
    /**
     * Render the error page.
     *
     * @param \Throwable $e
     */
    public static function render(\Throwable $e)
    {
        View::render('error', compact('e'));
    }
}

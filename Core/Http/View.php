<?php

namespace kiwi\Http;

use kiwi\Container;

class View
{
    /**
     * Render a view.
     *
     * @param string $view
     * @param array  $extracts
     *
     * @return View
     */
    public static function render($view, array $extracts = [])
    {
        $view = 'App'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.$view;

        self::finish($view, $extracts);
    }

    /**
     * Render an admin view.
     *
     * @param string $view
     * @param array  $extracts
     */
    public static function renderAdminView($view, array $extracts = [])
    {
        $view = 'core/admin/views/'.$view;

        self::finish($view, $extracts);
    }

    /**
     * Extract variables, apply $app and include the view.
     *
     * @param  string $view
     * @param  array  $extracts
     * @return void
     */
    public static function finish($view, array $extracts = [])
    {
        extract($extracts, EXTR_SKIP);

        require "{$view}.view.php";
    }
}

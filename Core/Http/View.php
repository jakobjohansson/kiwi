<?php

namespace kiwi\Http;

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
        $view = 'Core'.DIRECTORY_SEPARATOR.'Admin'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.$view;

        self::finish($view, $extracts);
    }

    /**
     * Extract variables, apply error bag and include the view.
     *
     * @param string $view
     * @param array  $extracts
     *
     * @return void
     */
    public static function finish($view, array $extracts = [])
    {
        extract($extracts, EXTR_SKIP);

        $errors = resolve('bag');

        require "{$view}.view.php";
    }
}

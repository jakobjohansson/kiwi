<?php

namespace kiwi\Http;

use kiwi\System\Templating\Engine;

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
        $view = 'App' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $view;

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
        $view = 'Core' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $view;

        self::finish($view, $extracts);
    }

    /**
     * Extract variables, apply error bag and compile the view.
     *
     * @param string $view
     * @param array  $extracts
     *
     * @return void
     */
    public static function finish($view, array $extracts = [])
    {
        $extract['errors'] = resolve('bag');

        $engine = new Engine("{$view}.view.php", $extracts);

        $engine->compile();
    }
}

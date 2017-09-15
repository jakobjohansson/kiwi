<?php

namespace kiwi\Http;

use kiwi\System\Filesystem;
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
        $extracts['errors'] = resolve('bag');

        if (Filesystem::find("App/Storage/{$view}.view.php")) {
            extract($extracts);

            return require "App/Storage/{$view}.view.php";
        }

        $engine = new Engine("App/Views/{$view}.view.php", $extracts);

        $engine->compile();
    }
}

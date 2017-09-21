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
        self::finish($view.'.view.php', $extracts);
    }

    /**
     * Render an admin view.
     *
     * @param string $view
     * @param array  $extracts
     */
    public static function renderAdminView($view, array $extracts = [])
    {
        $view = 'framework' . DIRECTORY_SEPARATOR . 'Admin' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $view;

        extract($extracts);

        return require $view.'.view.php';
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

        if (Filesystem::find("cache/{$view}")) {
            extract($extracts);

            return require "cache/{$view}";
        }

        $engine = new Engine("app/Views/{$view}", $extracts);

        $engine->compile();
    }
}

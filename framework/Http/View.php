<?php

namespace kiwi\Http;

use kiwi\Templating\Engine;
use kiwi\Filesystem\Filesystem;

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
        self::finish('app.Views.' . $view, $extracts);
    }

    /**
     * Render an admin view.
     *
     * @param string $view
     * @param array  $extracts
     */
    public static function renderAdminView($view, array $extracts = [])
    {
        self::finish('framework.Admin.Views.' . $view, $extracts);
    }

    /**
     * Apply error bag, check for cache and include view.
     *
     * @param $path
     * @param array $extracts
     * @return void
     */
    public static function finish($path, array $extracts = [])
    {
        if (env('DEVELOPMENT_MODE') || !Filesystem::find("cache/{$path}.view.php")) {
            $engine = new Engine($path);

            $engine->compile();
        }

        $extracts['errors'] = resolve('bag');
        extract($extracts);

        return require "cache/{$path}.view.php";
    }
}

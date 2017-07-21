<?php

namespace kiwi;

class View
{
    /**
     * Render a view.
     * @method render
     * @param  string $view
     * @param  Query $query
     * @param  Array $extracts
     * @return View
     */
    public static function render($view, Query $query, array $extracts = null)
    {
        // TODO: Remove the need for Query.
        $app = Meta::getAll($query);

        if ($extracts) {
            extract($extracts);
        }

        return require "themes/{$app['theme']}/{$view}.view.php";
    }

    /**
     * Render a view not located in a theme.
     * @method renderCustom
     * @param  string       $path
     * @param  Query        $query
     * @param  Array       $extracts
     * @return View
     */
    public static function renderCustom($path, Query $query, array $extracts = null)
    {
        // TODO: Remove the need for Query.
        $app = Meta::getAll($query);

        if ($extracts) {
            extract($extracts);
        }

        return require "$path";
    }

    /**
     * Retrieve the available themes.
     * @method getThemeLinks
     * @return Array
     */
    public static function getThemeLinks()
    {
        return Filesystem::scanFolder('themes');
    }
}

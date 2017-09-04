<?php

namespace kiwi\Http;

use kiwi\System\Filesystem;
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
    public static function render($view, array $extracts = null)
    {
        $app = Container::resolve('app');

        if ($extracts) {
            extract($extracts);
        }

        return require 'App'.DIRECTORY_SEPARATOR.
            'Themes'.DIRECTORY_SEPARATOR."{$app->theme}".
            DIRECTORY_SEPARATOR."{$view}.view.php";
    }

    /**
     * Render a view not located in a theme.
     *
     * @param string $path
     * @param array  $extracts
     *
     * @return View
     */
    public static function renderCustom($path, array $extracts = null)
    {
        $app = Container::resolve('app');

        if ($extracts) {
            extract($extracts);
        }

        return require "$path";
    }

    /**
     * Retrieve the available themes.
     *
     * @return array
     */
    public static function getThemeLinks()
    {
        return Filesystem::scanFolder('App'.DIRECTORY_SEPARATOR.'Themes');
    }
}

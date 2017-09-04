<?php

namespace kiwi\Http;

use kiwi\Container;
use kiwi\System\Filesystem;

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
        $app = Container::resolve('app');

        extract($extracts, EXTR_SKIP);

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
    public static function renderCustom($path, array $extracts = [])
    {
        $app = Container::resolve('app');

        extract($extracts, EXTR_SKIP);

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

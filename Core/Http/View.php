<?php

namespace kiwi\Http;

class View
{
    /**
     * Render a view.
     *
     * @method render
     *
     * @param string $view
     * @param array  $extracts
     *
     * @return View
     */
    public static function render($view, array $extracts = null)
    {
        $app = Meta::getAll();

        if ($extracts) {
            extract($extracts);
        }

        return require 'Custom'.DIRECTORY_SEPARATOR.
            'themes'.DIRECTORY_SEPARATOR."{$app['theme']}".
            DIRECTORY_SEPARATOR."{$view}.view.php";
    }

    /**
     * Render a view not located in a theme.
     *
     * @method renderCustom
     *
     * @param string $path
     * @param array  $extracts
     *
     * @return View
     */
    public static function renderCustom($path, array $extracts = null)
    {
        $app = Meta::getAll();

        if ($extracts) {
            extract($extracts);
        }

        return require "$path";
    }

    /**
     * Retrieve the available themes.
     *
     * @method getThemeLinks
     *
     * @return array
     */
    public static function getThemeLinks()
    {
        return Filesystem::scanFolder('themes');
    }
}

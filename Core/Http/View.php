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
        extract($extracts, EXTR_SKIP);

        require 'App'.DIRECTORY_SEPARATOR."Views".DIRECTORY_SEPARATOR."{$view}.view.php";
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
        extract($extracts, EXTR_SKIP);

        require "$path";
    }
}

<?php

namespace kiwi\Http;

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
    public static function render($view, array $extracts = [])
    {
        $app = Container::resolve('app');

        extract($extracts, EXTR_SKIP);

        require 'App'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR."{$view}.view.php";
    }

    /**
     * Render an admin view.
     *
     * @param string $view
     * @param array  $extracts
     */
    public static function renderAdminView($view, array $extracts = [])
    {
        $view = 'core/admin/views/'.$view;
        self::renderCustom($view, $extracts);
    }

    /**
     * Render a view not located in a theme.
     *
     * @param string $view
     * @param array  $extracts
     *
     * @return View
     */
    public static function renderCustom($view, array $extracts = [])
    {
        $app = Container::resolve('app');

        extract($extracts, EXTR_SKIP);

        require "{$view}.view.php";
    }
}

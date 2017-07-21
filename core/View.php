<?php

namespace kiwi;

class View
{
    public static function render($view, $query, $extracts = null)
    {
        $app = Meta::getAll($query);

        if ($extracts) {
            extract($extracts);
        }

        return require "themes/{$app['theme']}/{$view}.view.php";
    }
}

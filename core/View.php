<?php

namespace kiwi;

class View
{
    public static function render($view, $query)
    {
        $theme = Meta::get('theme', $query);
        return require "themes/{$theme}/{$view}.view.php";
    }
}

<?php

/**
 * kiwi helpers file.
 */
if (!function_exists('dd')) {
    function dd($param)
    {
        echo '<pre>';
        var_dump($param);
        echo '</pre>';
        die();
    }
}

if (!function_exists('resolve')) {
    function resolve($key)
    {
        return \kiwi\Container::resolve($key);
    }
}

if (!function_exists('bind')) {
    function bind($key, $value)
    {
        \kiwi\Container::bind($key, $value);
    }
}

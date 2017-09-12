<?php

/**
 * kiwi helpers file.
 */
if (! function_exists('dd')) {
    function dd(...$params)
    {
        echo '<pre><code>';
        var_dump(...$params);
        echo '</code></pre>';
        die();
    }
}

if (! function_exists('resolve')) {
    function resolve($key)
    {
        return \kiwi\Container::resolve($key);
    }
}

if (! function_exists('bind')) {
    function bind($key, $value)
    {
        \kiwi\Container::bind($key, $value);
    }
}

if (! function_exists('route')) {
    function route()
    {
        return kiwi\Http\Request::uri();
    }
}

if (! function_exists('isRoute')) {
    function isRoute($route)
    {
        return kiwi\Http\Request::uri() === $route;
    }
}

if (! function_exists('env')) {
    function env($name)
    {
        return getenv($name);
    }
}

if (! function_exists('app')) {
    function app()
    {
        return kiwi\Container::resolve('app');
    }
}

if (! function_exists('auth')) {
    function auth()
    {
        return app()->auth;
    }
}

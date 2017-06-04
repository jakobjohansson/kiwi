<?php

namespace kiwi;

class Request
{
    /**
     * Returns full URI.
     *
     * @return string URI
     */
    public static function uri()
    {
        return trim(
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'
        );
    }

    /**
     * Fetch the request method.
     *
     * @return string Request method
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Redirect the user.
     *
     * @param string $path the path to redirect
     *
     * @return header
     */
    public static function redirect($path)
    {
        return header("Location: $path");
    }
}

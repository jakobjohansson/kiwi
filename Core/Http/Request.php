<?php

namespace kiwi\Http;

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
            parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            '/'
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
     * @return void
     */
    public static function redirect($path)
    {
        header("Location: $path");
        exit;
    }

    /**
     * Put validation bag in session and redirect back.
     *
     * @return void
     */
    public static function back()
    {
        resolve('session')->set('errors', resolve('bag')->errors);

        self::redirect('/' . Request::uri());
    }
}

<?php namespace kiwi;

class Request
{

    /**
     * Returns full URI.
     *
     * @return String URI
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
     * @return String Request method
     */
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}

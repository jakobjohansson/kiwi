<?php

namespace kiwi\Http;

use kiwi\Http\Contracts\InputInterface;

class Input implements InputInterface
{
    /**
     * Returns a sanitized POST field.
     *
     * @param string $key the input field
     *
     * @return string
     */
    public static function field($key)
    {
        return Sanitizer::input($_POST[$key]);
    }

    /**
     * Returns a sanitized GET field.
     *
     * @param string $key the input field
     *
     * @return string
     */
    public static function query($key)
    {
        return Sanitizer::input($_GET[$key]);
    }

    /**
     * Returns all GET and POST variables in a collection.
     *
     * @return array Sanitized array.
     */
    public static function all()
    {
        $collection = [];

        foreach ($_POST as $key => $value) {
            $collection[$key] = Sanitizer::input($_POST[$key]);
        }

        foreach ($_GET as $key => $value) {
            $collection[$key] = Sanitizer::input($_GET[$key]);
        }

        return $collection;
    }
}

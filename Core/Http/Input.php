<?php

namespace kiwi\Http;

use kiwi\Http\Contracts\InputInterface;

class Input implements InputInterface
{
    /**
     * Return a sanitized and validated POST field.
     *
     * @param string $key
     * @param mixed  $rules
     *
     * @return string
     */
    public static function field($key, $rules = null)
    {
        if ($rules) {
            Enforcer::check($key, $rules);
        }

        return Sanitizer::input($_POST[$key]);
    }

    /**
     * Return a sanitized GET field.
     *
     * @param string $key
     *
     * @return string
     */
    public static function query($key)
    {
        return Sanitizer::input($_GET[$key]);
    }

    /**
     * Return all GET and POST variables in a collection.
     *
     * @return array
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

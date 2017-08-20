<?php

namespace kiwi\Http;

use kiwi\Http\Contracts\InputInterface;

class Json implements InputInterface
{
    /**
     * Returns a sanitized JSON field.
     *
     * @param string $key the input field
     *
     * @return string
     */
    public static function field($key)
    {
        $json = json_decode(file_get_contents('php://input'), true);

        return Sanitizer::input($json[$key]);
    }

    /**
     * Sanitize all the fields in a JSON collection.
     *
     * @param string $type JSON
     *
     * @return array Sanitized array.
     */
    public static function all()
    {
        $json = json_decode(file_get_contents('php://input'), true);
        $sendback = [];

        foreach ($json as $key => $value) {
            $sendback[$key] = Sanitizer::input($json[$key]);
        }

        return $sendback;
    }
}

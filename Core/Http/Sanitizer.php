<?php

namespace kiwi;

class Sanitizer
{
    /**
     * Sanitize an input field.
     *
     * @param string $input
     *
     * @return string clean $input
     */
    public static function input($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);

        return $input;
    }

    /**
     * Return digits only from a string.
     *
     * @method digits
     *
     * @param string $input
     *
     * @return string
     */
    public static function digits($input)
    {
        // TODO: Return digits only from a string.
    }

    /**
     * Return letters only from a string.
     *
     * @method letters
     *
     * @param mixed $input
     *
     * @return mixed
     */
    public static function letters($input)
    {
        // TODO: Return letters only from a string.
    }
}

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

    public static function digits($input)
    {
        // TODO: Return digits only from a string.
    }

    public static function letters($input)
    {
        // TODO: Return letters only from a string.
    }
}

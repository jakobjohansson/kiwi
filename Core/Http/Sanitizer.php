<?php

namespace kiwi\Http;

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
}

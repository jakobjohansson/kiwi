<?php namespace kiwi;

class Sanitizer
{
    public static function input($input)
    {
        $input = trim($input);
        $input = htmlspecialchars($input);
        return $input
    }
}

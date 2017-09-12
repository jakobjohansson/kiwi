<?php

namespace kiwi\Http;

class Rule
{
    public static function min($string, $offset)
    {
        return strlen($string) > $offset;
    }

    public static function max($string, $offset)
    {
        return strlen($string) <= $offset;
    }

    public static function required($string)
    {
        return !empty($string);
    }
}

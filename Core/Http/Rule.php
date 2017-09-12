<?php

namespace kiwi\Http;

class Rule
{
    /**
     * Set a minimum string length rule.
     *
     * @param  string $string
     * @param  int $offset
     * @return bool
     */
    public static function min($string, $offset)
    {
        return strlen($string) >= $offset;
    }

    /**
     * Set a maximum string length rule.
     *
     * @param  string $string
     * @param  int $offset
     * @return bool
     */
    public static function max($string, $offset)
    {
        return strlen($string) <= $offset;
    }

    /**
     * Set a required rule.
     *
     * @param  string $string
     * @return bool
     */
    public static function required($string)
    {
        return !empty($string);
    }
}

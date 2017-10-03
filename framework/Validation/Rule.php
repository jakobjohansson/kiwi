<?php

namespace kiwi\Http;

class Rule
{
    /**
     * Set a required rule.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function required($string)
    {
        return !empty($string);
    }

    /**
     * Set a email validation rule.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function email($string)
    {
        return filter_var($string, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Set a URL validation rule.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function url($string)
    {
        return filter_var($string, FILTER_VALIDATE_URL);
    }

    /**
     * Set a minimum string length rule.
     *
     * @param string $string
     * @param int    $offset
     *
     * @return bool
     */
    public static function min($string, $offset)
    {
        return strlen($string) >= $offset;
    }

    /**
     * Set a maximum string length rule.
     *
     * @param string $string
     * @param int    $offset
     *
     * @return bool
     */
    public static function max($string, $offset)
    {
        return strlen($string) <= $offset;
    }

    /**
     * Set a alphabetical only rule.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function alpha($string)
    {
        return preg_match('/^[A-Za-zÅÄÖåäö]+$/', $string) === 1;
    }

    /**
     * Set a digits only rule.
     *
     * @param string $string
     *
     * @return bool
     */
    public static function digits($string)
    {
        return preg_match('/^\d+$/', $string) === 1;
    }
}

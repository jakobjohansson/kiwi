<?php

namespace kiwi;

class Container
{
    /**
     * Value registry.
     *
     * @var array
     */
    private static $registry = [];

    /**
     * Bind a value to the container.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    /**
     * Resolve a value out of the container.
     *
     * @param string $key
     *
     * @return mixed
     */
    public static function resolve($key)
    {
        return static::$registry[$key];
    }
}

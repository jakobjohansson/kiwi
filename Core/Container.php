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
     * Bind an array of values to the container.
     * @param  array  $binds
     * @return void
     */
    public static function bindArray(array $binds)
    {
        foreach ($binds as $key => $value) {
            self::bind($key, $value);
        }
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
        return static::$registry[$key] ?? null;
    }
}

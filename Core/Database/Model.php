<?php

namespace kiwi\Database;

abstract class Model
{
    public static $connection;

    public static function boot($connection)
    {
        static::$connection = $connection;
    }

    public static function builder()
    {
        return new Builder(static::$connection);
    }
}

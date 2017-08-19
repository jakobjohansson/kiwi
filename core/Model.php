<?php

namespace kiwi;

abstract class Model
{

    public static $connection;

    public static function boot($connection)
    {
        static::$connection = $connection;
    }

    public static function builder()
    {
        return new Query(static::$connection);
    }
}

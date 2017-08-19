<?php

namespace kiwi;

abstract class Model
{
    public static $query;

    public static function boot($query)
    {
        static::$query = new Query($query);
    }
}

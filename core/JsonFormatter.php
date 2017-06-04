<?php

namespace kiwi;

class JsonFormatter implements FormatterInterface
{
    public static function make($value)
    {
        return json_encode($value);
    }

    public static function get($value)
    {
        return json_decode($value);
    }
}

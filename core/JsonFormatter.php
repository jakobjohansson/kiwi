<?php

namespace kiwi;

class JsonFormatter implements FormatterInterface
{
    /**
     * Turn a resource into JSON.
     * @method make
     * @param  mixed $value
     * @return mixed
     */
    public static function make($value)
    {
        return json_encode($value);
    }

    /**
     * Translate JSON into a readable resource.
     * @method get
     * @param  mixed $value
     * @return mixed
     */
    public static function get($value)
    {
        return json_decode($value);
    }
}

<?php

namespace kiwi\Http;

use kiwi\Http\Contracts\FormatterInterface;

class JsonFormatter implements FormatterInterface
{
    /**
     * Turn a resource into JSON.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function make($value)
    {
        return json_encode($value);
    }

    /**
     * Translate JSON into a readable resource.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    public static function get($value)
    {
        return json_decode($value);
    }
}

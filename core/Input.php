<?php namespace kiwi;

class Input implements InputInterface
{
    public static function field($key)
    {
        return Sanitizer::input($key);
    }
}

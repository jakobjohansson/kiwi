<?php namespace kiwi;

class Validation
{
    public static function password($one, $two)
    {
        return $one === $two && strlen($one) > 5;
    }
}

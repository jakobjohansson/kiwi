<?php

namespace kiwi;

class Validation
{
    public static function password($one, $two)
    {
        return $one === $two && strlen($one) > 5;
    }

    public static function username($username)
    {
        // TODO: Validate username against A-Za-Z0-9
    }
}

<?php

namespace kiwi\Database;

use kiwi\Container;

abstract class Model
{

    public static function builder()
    {
        return new Builder(Container::resolve('connection'));
    }
}

<?php

namespace kiwi\Http\Contracts;

interface InputInterface
{
    public static function field($key);

    public static function all();
}

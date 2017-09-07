<?php

namespace kiwi\Http;

class Session
{

    public function __construct()
    {
        session_start();
        return $this;
    }

    public function set($key, $value)
    {
        $_SESSION[$key] =$value;
        return $this;
    }

    public function get($key)
    {
        return $_SESSION[$key];
    }

    public static function make()
    {
        return new static();
    }
}

<?php

namespace kiwi\Http;

abstract class Controller
{
    public function __construct()
    {
        if (method_exists($this, 'middleware')) {
            return $this->middleware();
        }
    }
}

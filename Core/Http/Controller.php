<?php

namespace kiwi\Http;

abstract class Controller
{
    /**
     * Create a new Controller instance.
     */
    public function __construct()
    {
        if (method_exists($this, 'middleware')) {
            return $this->middleware();
        }
    }
}

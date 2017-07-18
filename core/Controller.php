<?php

namespace kiwi;

abstract class Controller
{
    public $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}

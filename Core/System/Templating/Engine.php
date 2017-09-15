<?php

namespace kiwi\System\Templating;

class Engine
{
    /**
     * The file to interpret.
     *
     * @var string
     */
    private $file;

    public function __construct($file)
    {
        $this->file = $file;
    }
}

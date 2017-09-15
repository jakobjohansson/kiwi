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

    /**
     * Create a new Engine instance.
     *
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }
}

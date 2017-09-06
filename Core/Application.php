<?php

namespace kiwi;

class Application
{
    /**
     * The application name.
     *
     * @var string
     */
    public $name;

    /**
     * The application description.
     *
     * @var string
     */
    public $description;

    /**
     * Create a new Application instance.
     *
     * @param string $name
     * @param string $description
     */
    public function __construct($name, $description)
    {
        $this->name = $name;
        $this->description = $description;
    }
}

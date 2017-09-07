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

    public $auth;

    /**
     * Create a new Application instance.
     *
     * @param string $name
     * @param string $description
     */
    public function __construct($name, $description, Auth $auth)
    {
        $this->name = $name;
        $this->description = $description;
        $this->auth = $auth;
    }
}

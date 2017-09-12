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
     * The auth object.
     *
     * @var Auth
     */
    public $auth;

    /**
     * Create a new Application instance.
     *
     * @param string $name
     * @param string $description
     * @param Auth   $auth
     */
    public function __construct()
    {
        $this->name = env('APP_NAME');
        $this->description = env('APP_DESCRIPTION');
        $this->auth = resolve('auth');
    }

    /**
     * Fancy constructor.
     *
     * @return self
     */
    public static function make()
    {
        return new self();
    }
}

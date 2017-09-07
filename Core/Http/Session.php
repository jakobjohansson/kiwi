<?php

namespace kiwi\Http;

class Session
{

    /**
     * Create a new Session instance.
     */
    public function __construct()
    {
        session_start();
        return $this;
    }

    /**
     * Set a session key.
     *
     * @param string $key
     * @param string $value
     */
    public function set($key, $value)
    {
        $_SESSION[$key] =$value;
        return $this;
    }

    /**
     * Get a session value.
     *
     * @param  string $key
     * @return mixed
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    /**
     * Destroy the session.
     *
     * @return void
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * Fancy constructor.
     *
     * @return static
     */
    public static function make()
    {
        return new static();
    }
}

<?php

namespace kiwi\Authentication;

class Session
{
    /**
     * Create a new Session instance.
     *
     * @return $this
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
     *
     * @return $this
     */
    public function set($key, $value)
    {
        $_SESSION[$key] = $value;

        return $this;
    }

    /**
     * Get a session value.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Unset a session key.
     *
     * @param mixed $key
     *
     * @return void
     */
    public function unset($key)
    {
        unset($_SESSION[$key]);
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
     * @return self
     */
    public static function make()
    {
        return new self();
    }
}

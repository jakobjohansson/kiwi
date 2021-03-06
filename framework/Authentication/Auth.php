<?php

namespace kiwi;

class Auth
{
    /**
     * The authorization status.
     *
     * @var bool
     */
    private $status = false;

    /**
     * The Session object.
     *
     * @var Session
     */
    private $session;

    /**
     * Create a new Auth instance.
     */
    public function __construct()
    {
        $this->session = resolve('session');

        $this->status = $this->session->get('auth');
    }

    /**
     * Return the authorization status.
     *
     * @return bool
     */
    public function check()
    {
        return $this->status;
    }

    /**
     * Attempt to login.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public function attempt($username, $password)
    {
        if ($this->matchCredentials($username, $password)) {
            $this->setAuth();
        }

        return $this->status;
    }

    /**
     * Check if credentials match.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    private function matchCredentials($username, $password)
    {
        return $username === env('USERNAME') && $password === env('PASSWORD');
    }

    /**
     * Set the session and auth status.
     *
     * @return void
     */
    private function setAuth()
    {
        $this->status = true;

        $this->session->set('auth', true);
    }

    /**
     * Destroy the session, logging the user out.
     *
     * @return void
     */
    public function destroy()
    {
        $this->session->destroy();
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

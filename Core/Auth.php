<?php

namespace kiwi;

use kiwi\Http\Session;

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
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;

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
     * @param  string $username
     * @param  string $password
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
     * @param  string $username
     * @param  string $password
     * @return bool
     */
    private function matchCredentials($username, $password)
    {
        return $username === env('USERNAME') && $password === env('PASSWORD');
    }

    /**
     * Set the session and auth status.
     */
    private function setAuth()
    {
        $this->status = true;

        $this->session->set('auth', true);
    }
}

<?php

namespace kiwi;

use kiwi\Http\Session;

class Auth
{
    private $status = false;

    private $session;

    public function __construct(Session $session)
    {
        $this->session = $session;

        $this->status = $this->session->get('auth');
    }

    public function check()
    {
        return $this->status;
    }

    public function attempt($username, $password)
    {
        if ($this->login($username, $password)) {
            $this->setAuth();
        }

        return $this->status;
    }

    private function login($username, $password)
    {
        return $username === env('USERNAME') && $password === env('PASSWORD');
    }

    private function setAuth()
    {
        $this->status = true;

        $this->session->set('auth', true);
    }
}

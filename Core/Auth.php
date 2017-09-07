<?php

namespace kiwi;

class Auth
{
    private $status = false;

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

        $this->session->make('auth', true);
    }
}

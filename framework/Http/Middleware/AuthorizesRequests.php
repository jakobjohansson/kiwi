<?php

namespace kiwi\Http\Middleware;

use kiwi\Http\Request;
use kiwi\Authentication\Session;

trait AuthorizesRequests {
    /**
     * Dont access without authorizing.
     *
     * @return void
     */
    public function middleware()
    {
        if (!auth()->check()) {
            Request::redirect('/login');
        }
    }

}

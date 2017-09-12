<?php

namespace kiwi\Http;

class AuthController extends Controller
{
    /**
     * Render the login form.
     *
     * @return void
     */
    public function login()
    {
        if (auth()->check()) {
            Request::redirect('admin');
        }

        View::renderAdminView('login');
    }

    /**
     * Attempt to log the user in, provided username and password fields.
     *
     * @return void
     */
    public function attempt()
    {
        if (auth()->attempt(Input::field('username'), Input::field('password'))) {
            Request::redirect('admin');
        }

        View::renderAdminView('login', [
            'username' => Input::field('username'),
            'password' => Input::field('password'),
            'error' => 'Invalid username or password.'
        ]);
    }

    /**
     * Log the user out.
     *
     * @return void
     */
    public function logout()
    {
        auth()->destroy();

        Request::redirect('/');
    }
}

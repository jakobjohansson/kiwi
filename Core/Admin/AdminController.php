<?php

namespace kiwi\Http;

use kiwi\Database\Post;
use kiwi\Database\User;

class AdminController extends Controller
{
    /**
     * Render the index page.
     *
     * @return void
     */
    public function index()
    {
        View::renderAdminView(
            'index',
            [
                'posts' => Post::all(),
            ]
        );
    }

    /**
     * Render the write page.
     *
     * @return void
     */
    public function create()
    {
        View::renderAdminView('create');
    }

    /**
     * Render the options page.
     *
     * @return void
     */
    public function options()
    {
        View::renderAdminView('options');
    }
}

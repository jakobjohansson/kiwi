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
        View::renderCustom(
            'core/admin/views/index.view.php',
            [
                'posts' => Post::all(),
                'page'  => 'browse',
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
        View::renderCustom(
            'core/admin/views/create.view.php',
            [
                'page' => 'write',
            ]
        );
    }

    /**
     * Render the users page.
     *
     * @return void
     */
    public function users()
    {
        View::renderCustom(
            'core/admin/views/users.view.php',
            [
                'users' => User::all(),
                'page' => 'users'
            ]
        );
    }

    /**
     * Render the options page.
     *
     * @return void
     */
    public function options()
    {
        View::renderCustom(
            'core/admin/views/options.view.php',
            [
                'page' => 'options',
                'themes' => View::getThemeLinks()
            ]
        );
    }
}

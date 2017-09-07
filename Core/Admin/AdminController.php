<?php

namespace kiwi\Http;

use kiwi\Database\Post;
use kiwi\Error\AuthException;

class AdminController extends Controller
{
    public function middleware()
    {
        if (!auth()->check()) {
            throw new AuthException('You are not authorized to access this page.');
        }
    }

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

    public function store()
    {
        $post = new Post();

        $post->body = Input::field('body');
        $post->title = Input::field('title');

        $post->save();

        Request::redirect('/admin');
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

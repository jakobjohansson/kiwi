<?php

namespace kiwi\Http;

use kiwi\Database\Post;

class AdminController extends Controller
{
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
     * Store a post in the database.
     *
     * @return void
     */
    public function store()
    {
        $post = new Post();

        $post->title = Input::field('title');
        $post->body = Input::field('body');

        $post->save();

        Request::redirect('/admin');
    }
}

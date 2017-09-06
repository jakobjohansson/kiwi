<?php

namespace kiwi\Http;

use kiwi\Database\Post;

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

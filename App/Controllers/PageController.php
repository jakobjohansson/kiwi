<?php

namespace kiwi\Http;

use kiwi\Database\Post;

class PageController extends Controller
{
    /**
     * Render the main page.
     *
     * @return void
     */
    public function index()
    {
        View::render('index', ['posts' => Post::all()]);
    }

    /**
     * Render a specific post page.
     *
     * @return void
     */
    public function show($id)
    {
        View::render('post', ['post' => Post::from($id)]);
    }
}

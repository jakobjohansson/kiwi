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
}

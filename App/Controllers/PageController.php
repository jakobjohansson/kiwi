<?php

namespace kiwi\Http;

use kiwi\Database\Post;

class PageController extends Controller
{
    public function index()
    {
        View::render('index', ['posts' => Post::all()]);
    }
}

<?php

namespace kiwi\Http;

class PageController extends Controller
{
    public function index()
    {
        View::render('index', ['posts' => Post::all()]);
    }
}

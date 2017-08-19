<?php

namespace kiwi;

class PageController extends Controller
{
    public function index()
    {
        View::render('index', ['posts' => Post::all()]);
    }
}

<?php

namespace kiwi\Http;

use kiwi\Database\Post;

class AdminController extends Controller
{
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

    public function create()
    {
        View::renderCustom(
            'core/admin/views/create.view.php',
            [
                'page' => 'write',
            ]
        );
    }
}

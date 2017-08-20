<?php

namespace kiwi\Admin;

class AdminController extends Controller
{
    public function index()
    {
        View::renderCustom(
            'core/admin/views/index.view.php',
            ['themes' => View::getThemeLinks()]
        );
    }
}

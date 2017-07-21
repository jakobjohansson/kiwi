<?php

namespace kiwi;

class AdminController extends Controller
{
    public function index()
    {
        $themes = View::getThemeLinks();
        View::renderCustom('core/admin/views/index.view.php', $this->query, ['themes' => $themes]);
    }
}

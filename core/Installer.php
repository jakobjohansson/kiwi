<?php namespace kiwi;

class Installer
{
    /**
     * The path to the install folder.
     *
     * @var string
     */
    private static $path = 'install/';

    public function index()
    {
        require static::$path . 'index.view.php';
    }
}

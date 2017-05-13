<?php namespace kiwi;

class Installer
{
    /**
     * The path to the install folder.
     *
     * @var string
     */
    private static $path = 'install/';

    /**
     * Initiate the installer
     *
     * @return void
     */
    public function initiate()
    {
        require static::$path . 'index.view.php';
    }
}

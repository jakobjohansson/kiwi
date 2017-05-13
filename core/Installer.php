<?php namespace kiwi;

class Installer
{
    private static $path = 'install/';
    /**
     * Initiate the installer.
     *
     * @return void
     */
    public static function initiate()
    {
        require static::$path . 'index.view.php';
        exit;
    }
}

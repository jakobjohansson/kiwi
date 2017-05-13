<?php namespace kiwi;

class Installer
{
    /**
     * The path to the views folder.
     *
     * @var string
     */
    private static $path = 'install/views/';

    /**
     * Initiate the installer
     *
     * @return void
     */
    public function initiate()
    {
        require static::$path . 'index.view.php';
    }

    /**
     * Show the view for the database settings
     *
     * @return void
     */
    public function getDatabaseView()
    {
        require static::$path . 'connection.view.php';
    }

    /**
     * Show the view for creating the administrator.
     *
     * @return void
     */
    public function getUserView()
    {
        require static::$path . 'user.view.php';
    }

    /**
     * Show the success view
     *
     * @return void
     */
    public function getSuccessView()
    {
        require static::$path . 'success.view.php';
    }
}

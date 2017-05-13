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
     * Process the database settings
     *
     * @return [type] [description]
     */
    public function postDatabase()
    {
    }

    /**
     * Format and send test connection results
     *
     * @return [type] [description]
     */
    public function postTestConnection()
    {
        $connection = Connection::testConnection(Json::all());

        if ($connection) {
            echo JsonFormatter::make([
                'status' => $connection,
                'message' => 'Connection working!'
            ]);
        } else {
            echo JsonFormatter::make([
                'status' => $connection,
                'message' => 'Unable to connect.'
            ]);
        }
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

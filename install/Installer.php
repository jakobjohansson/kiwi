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
        $this->requireFile('index');
    }

    /**
     * Show the view for the database settings
     *
     * @return void
     */
    public function getDatabaseView()
    {
        $this->requireFile('connection');
    }

    /**
     * Show the view for creating the administrator.
     *
     * @return void
     */
    public function getUserView()
    {
        $this->requireFile('user');
    }

    /**
     * Show the success view
     *
     * @return void
     */
    public function getSuccessView()
    {
        $this->requireFile('success');
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
                'status' => "success",
                'message' => 'Connection working!'
            ]);
        } else {
            echo JsonFormatter::make([
                'status' => "error",
                'message' => 'Unable to connect.'
            ]);
        }
    }

    /**
     * Process the database settings
     *
     * @return [type] [description]
     */
    public function postDatabase()
    {
    }

    public function requireFile($file)
    {
        require static::$path . 'partials/head.view.php';
        require static::$path . $file . '.view.php';
        require static::$path . 'partials/foot.view.php';
    }
}

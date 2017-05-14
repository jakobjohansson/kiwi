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
     * @return JsonFormatter
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
     * Process the database settings and put them in the config file.
     *
     * @return Request::redirect
     */
    public function postDatabase()
    {
        if (Connection::testConnection(Input::all('POST'))) {
            // format and write
            $str = sprintf("
                <?php\n
                return [
                    'host' => '%s',
                    'username' => '%s',
                    'password' => '%s',
                    'name' => '%s',
                    'options' => [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]
                ];
            ",
            Input::field('host'),
            Input::field('username'),
            Input::field('password'),
            Input::field('name'));

            Filesystem::write($str, 'config.php');

            return Request::redirect('/install/user');
        } else {
            return Request::redirect('/install/database');
        }
    }

    /**
     * Adds the administrator user to the database.
     *
     * @return Request::redirect()
     */
    public function postUserView()
    {
        if (Validation::password('password', 'password_confirm')) {
            // First migrate the tables
            $this->migrate();
        }
    }

    /**
     * Helper method to include header and footer and view suffix on main file.
     *
     * @param  string $file the file name without view.php
     * @return void
     */
    private function requireFile($file)
    {
        require static::$path . 'partials/head.view.php';
        require static::$path . $file . '.view.php';
        require static::$path . 'partials/foot.view.php';
    }

    /**
     * Migrate tables to database.
     *
     * @return boolean
     */
    private function migrate()
    {
    }
}

<?php namespace kiwi;

class Installer
{
    /**
     * The path to the views folder.
     *
     * @var string
     */
    private static $views = 'install/views/';

    /**
     * The path to the migrations folder
     *
     * @var string
     */
    private static $migs = 'install/migrations/';

    /**
     * Database connection.
     *
     * @var PDO
     */
    private $pdo;

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

            return Request::redirect('/user');
        }

        return Request::redirect('/database');
    }

    /**
     * Adds the administrator user to the database.
     *
     * @return Request::redirect()
     */
    public function postUserView()
    {
        if (Validation::password(Input::field('password'), Input::field('password_confirm'))) {
            // First migrate the tables
            $this->initiateMigration();
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
        require static::$views . 'partials/head.view.php';
        require static::$views . $file . '.view.php';
        require static::$views . 'partials/foot.view.php';
    }

    /**
     * Initiate the migration
     *
     * @return [type] [description]
     */
    private function initiateMigration()
    {
        // Let's make an ugly temporary connection to the database.
        $this->pdo = Connection::make(require 'config.php');
        $this->migrateTables();
        $this->migrateInitialInfo();
    }

    /**
     * Migrate tables to database.
     *
     * @return boolean
     */
    private function migrateTables()
    {
        $this->pdo->query(require static::$migs . 'site_meta.php');
        $this->pdo->query(require static::$migs . 'users.php');
        $this->pdo->query(require static::$migs . 'types.php');
        $this->pdo->query(require static::$migs . 'items.php');
    }

    /**
     * Creates the admin user and initial info
     *
     * @return boolean
     */
    private function migrateInitialInfo()
    {
        $this->pdo->query(require static::$migs . 'site_meta_inserts.php');
        $this->pdo->query(require static::$migs . 'types_inserts.php');

        $stmt = $this->pdo->prepare("
            INSERT INTO `users` (`username`, `email`, `password`, `avatar`, `role`)
            VALUES (:username, :email, :password, NULL, 4);
        ");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        $username = Input::field('username');
        $email = Input::field('email');
        $password = password_hash(Input::field('password'), PASSWORD_DEFAULT);

        $stmt->execute();

        $this->pdo->query(require static::$migs . 'items_inserts.php');
    }
}

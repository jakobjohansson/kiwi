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

            return Request::redirect('/install/user');
        }

        return Request::redirect('/install/database');
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
        require static::$path . 'partials/head.view.php';
        require static::$path . $file . '.view.php';
        require static::$path . 'partials/foot.view.php';
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
        $sql = "CREATE TABLE IF NOT EXISTS `site_meta` (
            `meta_id` int(11) NOT NULL AUTO_INCREMENT,
            `key` varchar(255) NOT NULL DEFAULT '',
            `value` varchar(255) NOT NULL DEFAULT '',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`meta_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Meta data for the site, such as what theme to use, name, description, public etc.';";

        $this->pdo->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `users` (
            `user_id` int(11) NOT NULL AUTO_INCREMENT,
            `username` varchar(16) NOT NULL,
            `email` varchar(255) DEFAULT NULL,
            `password` varchar(32) NOT NULL,
            `avatar` varchar(45) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `role` int(11) NOT NULL DEFAULT '1' COMMENT '1: user,\n2: contributor,\n3: moderator,\n4: admin',
            PRIMARY KEY (`user_id`),
            UNIQUE KEY `username_UNIQUE` (`username`),
            UNIQUE KEY `email_UNIQUE` (`email`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Users table. The higher role number the higher privileges.';";

        $this->pdo->query($sql);

        $sql = "CREATE TABLE `types` (
            `type_id` int(11) NOT NULL AUTO_INCREMENT,
            `name` varchar(45) NOT NULL,
            PRIMARY KEY (`type_id`),
            UNIQUE KEY `name_UNIQUE` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Registered types of items. Defaults to post, project and comment.';";

        $this->pdo->query($sql);

        $sql = "CREATE TABLE IF NOT EXISTS `items` (
            `item_id` int(11) NOT NULL AUTO_INCREMENT,
            `type_id` int(11) DEFAULT NULL,
            `user_id` int(11) DEFAULT NULL,
            `title` varchar(255) DEFAULT NULL,
            `body` text,
            `public` tinyint(4) DEFAULT '1',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            `belongs_to_id` int(11) DEFAULT NULL,
            PRIMARY KEY (`item_id`),
            KEY `user_id_idx` (`user_id`),
            KEY `type_id_idx` (`type_id`),
            CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `types` (`type_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
            CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all items on the site.';";

        $this->pdo->query($sql);
    }

    /**
     * Creates the admin user and initial info
     *
     * @return boolean
     */
    private function migrateInitialInfo()
    {
        $sql = "INSERT INTO `site_meta` (`key`, `value`)
            VALUES
            ('name','kiwi'),
            ('description','an optional description of the site'),
            ('public','true'),
            ('theme','kiwi-default');";
        $this->pdo->query($sql);

        $sql = "INSERT INTO `types` (`type_id`, `name`)
            VALUES
            (3,'comment'),
            (1,'post'),
            (2,'project');";
        $this->pdo->query($sql);

        $stmt = $this->pdo->prepare("INSERT INTO `users` (`username`, `email`, `password`, `avatar`, `role`)
            VALUES
            (:username, :email, :password, NULL, 4);");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        $username = Input::field('username');
        $email = Input::field('email');
        $password = password_hash(Input::field('password'), PASSWORD_DEFAULT);

        $stmt->execute();

        $sql = "INSERT INTO `items` (`type_id`, `user_id`, `title`, `body`)
            VALUES
            (1,1,'This is an example post','Welcome to kiwi');";
        $this->pdo->query($sql);
    }
}

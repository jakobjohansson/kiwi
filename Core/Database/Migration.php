<?php

namespace kiwi\Database;

use kiwi\Container;

class Migration
{
    private $pdo;

    private $droppable = [];

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->drop()->migrate();
    }

    public static function refresh()
    {
        return new static(Container::resolve('connection'));
    }

    private function drop()
    {
        $query = $this->pdo->query('DROP TABLE IF EXISTS `posts`');

        $query->execute();

        return $this;
    }

    private function migrate()
    {
        $query = $this->pdo->query(
            "CREATE TABLE IF NOT EXISTS `posts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `title` varchar(255) DEFAULT NULL,
                `body` text,
                `public` tinyint(4) DEFAULT '1',
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all posts on the site.';"
        );

        $query->execute();

        $query = $this->pdo->prepare(
            "INSERT INTO `posts` (`title`, `body`)
                VALUES
                ('Hello World!','Welcome to kiwi! This is the first post');"
        );

        $query->execute();
    }
}

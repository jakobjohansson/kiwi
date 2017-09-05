<?php

namespace kiwi\Database;

class Migration
{
    private $migrationsPath;

    public static function refresh()
    {
    }

    private function refreshMigration()
    {
    }

    private function migrateTables()
    {
        $this->pdo->query(require static::$migs.'site_meta.php');
        $this->pdo->query(require static::$migs.'users.php');
        $this->pdo->query(require static::$migs.'types.php');
        $this->pdo->query(require static::$migs.'items.php');
    }

    private function seedTables()
    {
        return "CREATE TABLE IF NOT EXISTS `posts` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `title` varchar(255) DEFAULT NULL,
            `body` text,
            `public` tinyint(4) DEFAULT '1',
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`item_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Contains all posts on the site.';";

        return "INSERT INTO `items` (`id`, `title`, `body`)
            VALUES
            (1,'Hello World!','Welcome to kiwi! This is the first post');";
    }
}

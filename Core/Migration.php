<?php

namespace kiwi;

class Migration
{
    private $migrationsPath;

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
        $this->pdo->query(require static::$seeds.'site_meta.php');
        $this->pdo->query(require static::$seeds.'types.php');

        // TODO: Do admin user here.

        $this->pdo->query(require static::$seeds.'items.php');
    }
}

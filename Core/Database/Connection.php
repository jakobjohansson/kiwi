<?php

namespace kiwi\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * Create a PDO connection.
     *
     * @param array $params
     *
     * @return PDO
     */
    public static function make(array $params)
    {
        try {
            return new PDO(
                'mysql:host='.
                $params['host'].';dbname='.$params['name'],
                $params['username'],
                $params['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
}

<?php

namespace kiwi\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * Creates a PDO connection.
     *
     * @param array $params Array of credentials to the database
     *
     * @return PDO Connection
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
            ErrorHandler::render($e);
        }
    }
}

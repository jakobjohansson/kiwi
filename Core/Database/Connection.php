<?php

namespace kiwi\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * Create a PDO connection.
     *
     * @return PDO
     */
    public static function make()
    {
        try {
            return new PDO(
                'mysql:host=' .
                env('DATABASE_HOST') . ';dbname=' . env('DATABASE_NAME'),
                env('DATABASE_USER'),
                env('DATABASE_PASS'),
                [
                    PDO::ATTR_ERRMODE      => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
                ]
            );
        } catch (PDOException $e) {
            throw $e;
        }
    }
}

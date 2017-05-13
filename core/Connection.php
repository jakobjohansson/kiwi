<?php namespace kiwi;

use \PDO;
use \PDOException;

class Connection
{
    /**
     * Creates a PDO connection.
     *
     * @param  array  $params Array of credentials to the database
     * @return PDO         Connection
     */
    public static function create(array $params)
    {
        try {
            return new PDO(
                $params['host'].';dbname='.$params['name'],
                $params['username'],
                $params['password'],
                $params['options']
            );
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}

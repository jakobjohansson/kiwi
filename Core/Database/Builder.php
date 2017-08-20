<?php

namespace kiwi\Database;

use PDO;
use PDOException;

class Builder
{
    /**
     * PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    protected $format = PDO::FETCH_CLASS;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function setFormat($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Fetch a record from a table.
     *
     * @param string $table
     * @param mixed  $properties
     * @param array  $where
     *
     * @return mixed
     */
    public function select($table, $properties, array $where = null)
    {
        if (is_array($properties)) {
            $properties = implode($properties, ',');
        }

        $sql = "select {$properties} from {$table}";

        if ($where) {
            $where[0] = '`'.$where[0].'`';
            $where[2] = "'".$where[2]."'";
            $where = implode($where, ' ');
            $sql .= " WHERE {$where}";
        }

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetch($this->format);
        } catch (PDOException $exception) {
            ErrorHandler::renderErrorView($exception, $this);
        }
    }

    /**
     * Fetch all records from a table.
     *
     * @param string $table the table to select from
     *
     * @return array array of objects
     */
    public function selectAll($table, $class = null, array $where = null)
    {
        try {
            $sql = "select * from {$table}";

            if ($where) {
                $where[0] = '`'.$where[0].'`';
                $where[2] = "'".$where[2]."'";
                $where = implode($where, ' ');
                $sql .= " WHERE {$where}";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();

            if ($class) {
                return $stmt->fetchAll($this->format, $class);
            }

            return $stmt->fetchAll($this->format);
        } catch (PDOException $exception) {
            ErrorHandler::renderErrorView($exception, $this);
        }
    }

    /**
     * Insert records into a table.
     *
     * @param string $table      The table name
     * @param array  $parameters Array of contents
     *
     * @return void
     */
    public function insert($table, array $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':'.implode(', :', array_keys($parameters))
        );

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
        } catch (PDOException $exception) {
            ErrorHandler::renderErrorView($exception, $this);
        }
    }
}

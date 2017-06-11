<?php

namespace kiwi;

use \PDO;

class Query
{
    /**
     * PDO instance.
     *
     * @var PDO
     */
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Fetch a record from a table
     *
     * @param  string $table
     * @param  mixed $properties
     * @param  array $where
     * @return mixed
     */
    public function select($table, $properties, $where = null)
    {
        if (is_array($properties)) {
            $properties = implode($properties, ',');
        }

        $sql = "select {$properties} from {$table}";

        if ($where) {
            $where[0] = "`" . $where[0] . "`";
            $where[2] = "'" . $where[2] . "'";
            $where = implode($where, ' ');
            $sql .= " WHERE {$where}";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * Fetch all records from a table.
     *
     * @param string $table the table to select from
     *
     * @return array array of objects
     */
    public function selectAll($table)
    {
        $stmt = $this->pdo->prepare("select * from {$table}");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_CLASS);
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
        } catch (\Exception $exception) {
            //
        }
    }
}

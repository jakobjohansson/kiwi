<?php

namespace kiwi\Database;

use kiwi\Error\ErrorHandler;
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

    /**
     * Predefined fetch format.
     *
     * @var PDO
     */
    protected $format = PDO::FETCH_CLASS;

    /**
     * SQL query.
     *
     * @var string
     */
    protected $query;

    /**
     * Array of where clauses.
     *
     * @var array
     */
    protected $clauses;

    /**
     * The table to be queried.
     *
     * @var string
     */
    protected $table;

    /**
     * The properties to query.
     *
     * @var string
     */
    protected $properties = '*';

    /**
     * Creates a new Builder intance.
     *
     * @method __construct
     *
     * @param PDO $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Setter for the PDO format to use.
     *
     * @method format
     *
     * @param string $format
     *
     * @return $this
     */
    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Set the table to query.
     *
     * @method from
     *
     * @param string $table
     *
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Add a where clause to the query.
     *
     * @method where
     *
     * @return $this
     */
    public function where($one, $operator, $two)
    {
        $this->clauses[] = [$one, $operator, $two];

        return $this;
    }

    /**
     * Select the properties to run in the query.
     *
     * @method select
     *
     * @param mixed $properties
     *
     * @return $this
     */
    public function select($properties)
    {
        if (is_array($properties)) {
            $properties = $properties = implode($properties, ', ');
        }

        $this->properties = $properties;

        $this->setSelectQuery();

        return $this;
    }

    /**
     * Chain and run the query.
     *
     * @method run
     */
    public function run()
    {
        $this->query .= $this->table;
        $this->query .= $this->getProcessedWhereClauses();

        try {
            $statement = $this->pdo->prepare($this->query);
            $statement->execute();

            if ($class) {
                return $stmt->fetchAll($this->format, $class);
            }

            return $stmt->fetchAll($this->format);
        } catch (PDOException $exception) {
            ErrorHandler::renderErrorView($exception);
        }
    }

    /**
     * Sets an initial select query.
     *
     * @method setSelectquery
     */
    private function setSelectQuery()
    {
        $this->query = "SELECT {$this->properties} FROM ";
    }

    /**
     * Process the where clauses, concatenating them into a string.
     *
     * @method getProcessedWhereClauses
     *
     * @return string
     */
    private function getProcessedWhereClauses()
    {
        $count = count($this->where);

        if (!$count) {
            return;
        }

        $output = " WHERE `{$where[0][0]}` {$where[0][1]} '{$where[0][2]}'";

        if ($count > 1) {
            for ($i = 1; $i < $count; $i++) {
                $output .= " AND `{$where[$i][0]}` {$where[$i][1]} '{$where[$i][2]}'";
            }
        }

        return $output;
    }
}

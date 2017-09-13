<?php

namespace kiwi\Database;

use PDO;
use PDOException;
use kiwi\Error\ErrorHandler;

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
     * The expected class to return.
     *
     * @var string
     */
    protected $expect;

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
     * The order of the entities.
     *
     * @var string
     */
    protected $order;

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
     * Whether to fetch column only or not.
     *
     * @var bool
     */
    protected $columnOnly = false;

    /**
     * The table joins.
     *
     * @var array
     */
    protected $joins = [];

    /**
     * Creates a new Builder intance.
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
     * Set the expected class response.
     *
     * @param   $class
     *
     * @return $this
     */
    public function expect($class)
    {
        $this->expect = $class;

        return $this;
    }

    /**
     * Set the table to query.
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
     * Prepare a insert query.
     *
     * @param object $entity
     *
     * @return $this
     */
    public function insert($entity)
    {
        $keys = array_keys($entity->attributes);

        $this->query .= implode('`, `', $keys) . '`';

        $this->query .= ") VALUES ('";

        $this->query .= implode("', '", $entity->attributes) . "'";

        $this->query .= ');';

        return $this;
    }

    /**
     * Set the order to descending.
     *
     * @return $this
     */
    public function descending()
    {
        $this->order = " ORDER BY id DESC";

        return $this;
    }

    /**
     * Set the order to ascending.
     *
     * @return $this
     */
    public function ascending()
    {
        $this->order = " ORDER BY id ASC";

        return $this;
    }

    /**
     * Set which table to insert to.
     *
     * @param string $table
     *
     * @return $this
     */
    public function to($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * Retrieve only a single column from a query.
     *
     * @param string $property
     *
     * @return $this
     */
    public function column($property)
    {
        $this->properties = $property;

        $this->setSelectQuery();

        $this->columnOnly = true;

        return $this;
    }

    /**
     * Set a table to concatenate with (join).
     *
     * @param string $join
     *
     * @return $this
     */
    public function with($join)
    {
        $this->joins[] = $join;

        return $this;
    }

    /**
     * Chain and run a select query.
     *
     * @return PDO::Statement
     */
    public function get()
    {
        $this->query .= $this->table;
        $this->applyJoins();
        $this->query .= $this->getProcessedWhereClauses();

        if ($this->order) {
            $this->query .= $this->order;
        }

        try {
            $statement = $this->pdo->prepare($this->query);
            $statement->execute();

            if ($this->expect) {
                return $statement->fetchAll($this->format, $this->expect);
            }

            if ($this->columnOnly) {
                return $statement->fetchColumn();
            }

            return $statement->fetchAll($this->format);
        } catch (PDOException $e) {
            ErrorHandler::render($e);
        }
    }

    /**
     * Run a query.
     *
     * @return void
     */
    public function run()
    {
        $this->setInsertQuery();
        $statement = $this->pdo->prepare($this->query);

        $statement->execute();
    }

    /**
     * Sets an initial select query.
     */
    private function setSelectQuery()
    {
        $this->query = "SELECT {$this->properties} FROM ";
    }

    /**
     * Set an initial insert query.
     */
    private function setInsertQuery()
    {
        $this->query = 'INSERT INTO `' . $this->table . '` (`' . $this->query;
    }

    /**
     * Apply joins if there are any.
     *
     * @return void
     */
    private function applyJoins()
    {
        if (!count($this->joins)) {
            return;
        }

        foreach ($this->joins as $join) {
            $this->query .= " INNER JOIN {$join}";
        }
    }

    /**
     * Process the where clauses, concatenating them into a string.
     *
     * @return string
     */
    private function getProcessedWhereClauses()
    {
        $count = count($this->clauses);

        if (!$count) {
            return;
        }

        $output = " WHERE `{$this->clauses[0][0]}` {$this->clauses[0][1]} '{$this->clauses[0][2]}'";

        if ($count > 1) {
            for ($i = 1; $i < $count; $i++) {
                $output .= " AND `{$this->clauses[$i][0]}` {$this->clauses[$i][1]} '{$this->clauses[$i][2]}'";
            }
        }

        return $output;
    }
}

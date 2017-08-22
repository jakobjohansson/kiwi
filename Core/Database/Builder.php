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
     * SQL statement.
     * @var string
     */
    protected $statement;

    /**
     * Array of where clauses.
     * @var array
     */
    protected $clauses;

    /**
     * The table to be queried.
     * @var string
     */
    protected $table;

    /**
     * The properties to query.
     * @var string
     */
    protected $properties = '*';

    /**
     * Creates a new Builder intance.
     * @method __construct
     * @param  PDO      $pdo
     */
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Setter for the PDO format to use.
     * @method format
     * @param  string $format
     * @return $this
     */
    public function format($format)
    {
        $this->format = $format;

        return $this;
    }

    /**
     * Set the table to query.
     * @method from
     * @param  string $table
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
     * Run the query.
     *
     * @method run
     */
    public function run()
    {

        return $this;
    }
}

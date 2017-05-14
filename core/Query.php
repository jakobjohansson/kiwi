<?php namespace kiwi;

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
     * Fetch all records from a table
     *
     * @param  string $table the table to select from
     * @return array        array of objects
     */
    public function selectAll($table)
    {
        $statement = $this->pdo->prepare("select * from {$table}");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * Insert records into a table
     *
     * @param  string $table      The table name
     * @param  Array $parameters Array of contents
     * @return void
     */
    public function insert($table, array $parameters)
    {
        $sql = sprintf(
            'insert into %s (%s) values (%s)',
            $table,
            implode(', ', array_keys($parameters)),
            ':' . implode(', :', array_keys($parameters))
        );
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
        } catch (\Exception $e) {
            //
        }
    }
}

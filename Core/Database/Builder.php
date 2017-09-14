<?php

namespace kiwi\Database;

use PDO;

class Builder
{
    /**
     * The PDO connection.
     *
     * @var PDO
     */
    private $pdo;

    /**
     * The table to perform the query on.
     *
     * @var string
     */
    private $table;

    /**
     * The query to run.
     *
     * @var string
     */
    private $query;

    /**
     * The bound values.
     *
     * @var array
     */
    private $binds = [];

    /**
     * The query statement to run.
     *
     * @var PDO::Statement
     */
    private $statement;

    /**
     * The class to expect.
     *
     * @var string
     */
    private $expect;

    /**
     * Create a new Builder instance.
     *
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Fetch models from the database.
     *
     * @param string $model
     * @param int    $id
     *
     * @return object
     */
    public function fetch($model, $id = null)
    {
        //$this->setTableNameFromModel($model);
        $this->table = $model::$table;

        $this->expect = $model;

        $this->query = "SELECT * FROM $this->table";

        if (is_null($id)) {
            $this->query .= " ORDER BY id DESC";
            $this->createStatement();

            return $this->statement->fetchAll();
        }

        $this->query .= ' WHERE id = ?';
        $this->binds[] = $id;

        $this->createStatement();

        return $this->statement->fetch();
    }

    /**
     * Save a model to the database.
     *
     * @param Model $model
     *
     * @return void
     */
    public function save(Model $model)
    {
        $this->setTableNameFromModel($model);

        $this->expect = get_class($model);

        $attributes = implode(', ', array_keys($model->attributes));

        $values = '';

        foreach ($model->attributes as $attribute) {
            $values .= '?, ';
        }

        $values = rtrim($values, ', ');

        $this->query = "INSERT INTO $this->table ($attributes) VALUES ($values)";

        $this->binds = array_values($model->attributes);

        $this->createStatement();
    }

    /**
     * Update a model.
     *
     * @param Model $model
     *
     * @return void
     */
    public function update(Model $model)
    {
        //$this->table = strtolower(get_class($model)) . 's';
        $this->setTableNameFromModel($model);

        $this->expect = get_class($model);

        $values = implode('=?, ', array_keys($model->attributes));

        $values .= '=?';

        $this->query = "UPDATE $this->table SET $values WHERE id=?";

        $this->binds = array_values($model->attributes);
        $this->binds[] = $model->id;

        $this->createStatement();
    }

    /**
     * Remove a model from the database.
     *
     * @param Model $model
     *
     * @return void
     */
    public function remove(Model $model)
    {
        $this->setTableNameFromModel($model);
        $this->expect = get_class($model);
        $this->query = "DELETE FROM $this->table WHERE id=?";
        $this->binds[] = $model->id;

        $this->createStatement();
    }

    /**
     * Set the table name from a models name.
     *
     * @param Model $model
     *
     * @return void
     */
    private function setTableNameFromModel(Model $model)
    {
        $this->table = strtolower((new \ReflectionClass($model))->getShortName()) . 's';
    }

    /**
     * Create the final statement.
     *
     * @return PDO::Statement
     */
    private function createStatement()
    {
        $this->statement = $this->pdo->prepare($this->query);

        $this->statement->setFetchMode(PDO::FETCH_CLASS, $this->expect);

        return $this->statement->execute($this->binds);
    }
}

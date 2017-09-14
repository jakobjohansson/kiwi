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

    private $table;

    private $query;

    private $mode;

    private $binds = [];

    private $statement;

    private $expect;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function fetch($model, $id = null)
    {
        //$this->setTableNameFromModel($model);
        $this->table = $model::$table;

        $this->expect = $model;

        $this->query = "SELECT * FROM $this->table";

        if (is_null($id)) {
            $this->createStatement();
            return $this->statement->fetchAll();
        }

        $this->query .= " WHERE id = ?";
        $this->binds[] = $id;

        $this->createStatement();

        return $this->statement->fetch();
    }

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

    public function remove(Model $model) {
        $this->setTableNameFromModel($model);
        $this->expect = get_class($model);
        $this->query = "DELETE FROM $this->table WHERE id=?";
        $this->binds[] = $model->id;

        $this->createStatement();
    }

    private function createStatement()
    {
        $this->statement = $this->pdo->prepare($this->query);

        $this->statement->setFetchMode(PDO::FETCH_CLASS, $this->expect);

        $this->statement->execute($this->binds);
    }

    private function setTableNameFromModel($model)
    {
        $this->table = strtolower((new \ReflectionClass($model))->getShortName()) . 's';
    }
}

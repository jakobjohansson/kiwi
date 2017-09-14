<?php

namespace kiwi\Database;

use kiwi\Http\Request;

abstract class Model implements \ArrayAccess
{
    /**
     * Attributes set by ArrayAccess or magic methods.
     *
     * @var array
     */
    public $attributes = [];

    /**
     * Return a new instance of the Builder class.
     *
     * @return Builder
     */
    public static function builder()
    {
        return new Builder(resolve('connection'));
    }

    /**
     * Run specified validation.
     *
     * @return void
     */
    protected function runValidation()
    {
        $bag = resolve('bag');

        if (count($bag->errors)) {
            Request::back();
        }
    }

    /**
     * Check if an offset exists when using ArrayAccess.
     *
     * @param mixed $offset
     *
     * @return bool
     */
    public function offsetExists($offset)
    {
        return in_array($this->attributes, $offset);
    }

    /**
     * Get an attribute when using ArrayAccess.
     *
     * @param mixed $offset
     */
    public function offsetGet($offset)
    {
        return $this->attributes[$offset] ?? null;
    }

    /**
     * Set an attribute when using ArrayAccess.
     *
     * @param mixed $offset
     * @param mixed $value
     *
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->attributes[] = $value;

            return;
        }

        $this->attributes[$offset] = $value;
    }

    /**
     * Unset an attribute when using ArrayAccess.
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Dynamically get an attribute on the object.
     *
     * @param mixed $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (array_key_exists($property, $this->attributes)) {
            return $this->attributes[$property];
        }
    }

    /**
     * Dynamically set an attribute on the object.
     *
     * @param mixed $property
     * @param mixed $value
     */
    public function __set($property, $value)
    {
        $this->attributes[$property] = $value;
    }

    /**
     * Fetch a model from an id.
     *
     * @param int $id
     */
    public static function from($id)
    {
        $builder = self::builder();

        return $builder->fetch(get_called_class(), $id);
    }

    /**
     * Fetch all models.
     *
     * @return array
     */
    public static function all()
    {
        $builder = self::builder();

        return $builder->fetch(get_called_class());
    }

    /**
     * Delete the current model.
     *
     * @return void
     */
    public function delete()
    {
        $builder = self::builder();

        $builder->remove($this);
    }

    /**
     * Update a model.
     *
     * @return void
     */
    public function update()
    {
        $this->runValidation();
        $builder = self::builder();

        $this->updated_at = date('Y-m-d H:i:s');

        $builder->update($this);
    }

    /**
     * Save a model to the database.
     *
     * @return PDOStatement
     */
    public function save()
    {
        $this->runValidation();
        $builder = self::builder();

        $builder->save($this);
    }
}

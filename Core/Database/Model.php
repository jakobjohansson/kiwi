<?php

namespace kiwi\Database;

use kiwi\Container;

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
        return new Builder(Container::resolve('connection'));
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
        } else {
            $this->attributes[$offset] = $value;
        }
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
}

<?php

namespace kiwi\Database;

use kiwi\Http\Request;

abstract class Model implements \ArrayAccess
{
    use InteractsWithBuilder;

    /**
     * Attributes set by ArrayAccess or magic methods.
     *
     * @var array
     */
    public $attributes = [];

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
        return in_array($offset, $this->attributes);
    }

    /**
     * Get an attribute when using ArrayAccess.
     *
     * @param mixed $offset
     *
     *
     * @return mixed|null
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
}

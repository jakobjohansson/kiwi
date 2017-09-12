<?php

namespace kiwi\Http;

use kiwi\Http\Contracts\InputInterface;

class Input implements InputInterface
{
    /**
     * Return a sanitized and validated POST field.
     *
     * @param string $key
     * @param mixed  $rules
     *
     * @return string
     */
    public static function field($key, $rules = null)
    {
        // TODO: refactor this method.
        if (! is_array($rules)) {
            $rules = [$rules];
        }

        $bag = resolve('bag');

        foreach ($rules as $rule => $message) {
            $rule = explode(':', $rule);

            if (method_exists(Rule::class, $rule[0])) {
                if (isset($rule[1])) {
                    if (! call_user_func_array([Rule::class, $rule[0]], [Sanitizer::input($_POST[$key]), $rule[1]])) {
                        $bag->$key = $message;
                    }
                } else {
                    if (! call_user_func_array([Rule::class, $rule[0]], [Sanitizer::input($_POST[$key])])) {
                        $bag->$key = $message;
                    }
                }
            }
        }

        return Sanitizer::input($_POST[$key]);
    }

    /**
     * Return a sanitized GET field.
     *
     * @param string $key
     *
     * @return string
     */
    public static function query($key)
    {
        return Sanitizer::input($_GET[$key]);
    }

    /**
     * Return all GET and POST variables in a collection.
     *
     * @return array
     */
    public static function all()
    {
        $collection = [];

        foreach ($_POST as $key => $value) {
            $collection[$key] = Sanitizer::input($_POST[$key]);
        }

        foreach ($_GET as $key => $value) {
            $collection[$key] = Sanitizer::input($_GET[$key]);
        }

        return $collection;
    }
}

<?php

namespace kiwi\Http;

use kiwi\Http\Contracts\InputInterface;

class Input implements InputInterface
{
    /**
     * Returns a sanitized and validated POST field.
     *
     * @param string $key the input field
     * @param mixed $rules
     *
     * @throws ValidationException
     * @return string
     */
    public static function field($key, $rules = null)
    {
        // TODO: refactor this method.
        if (!is_array($rules)) {
            $rules = [$rules];
        }

        $bag = resolve('ValidationBag');

        foreach ($rules as $rule => $message) {
            $rule = explode(':', $rule);

            if (method_exists(Rule::class, $rule[0])) {
                if (isset($rule[1])) {
                    if (!call_user_func_array([Rule::class, $rule[0]], [Sanitizer::input($_POST[$key]), $rule[1]])) {
                        $bag->$key = $message;
                    }
                } else {
                    if (!call_user_func_array([Rule::class, $rule[0]], [Sanitizer::input($_POST[$key])])) {
                        $bag->$key = $message;
                    }
                }
            }
        }

        return Sanitizer::input($_POST[$key]);
    }

    /**
     * Returns a sanitized GET field.
     *
     * @param string $key the input field
     *
     * @return string
     */
    public static function query($key)
    {
        return Sanitizer::input($_GET[$key]);
    }

    /**
     * Returns all GET and POST variables in a collection.
     *
     * @return array Sanitized array.
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

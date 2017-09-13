<?php

namespace kiwi\Http;

class Enforcer
{
    /**
     * The field key.
     *
     * @var string
     */
    private $key;

    /**
     * The validation rules.
     *
     * @var array
     */
    private $rules;

    /**
     * The field value.
     *
     * @var mixed
     */
    private $value;

    /**
     * The validation error bag.
     *
     * @var ValidationBag
     */
    private $bag;

    /**
     * Create a new Enforcer instance.
     *
     * @param mixed $key
     * @param array $rules
     */
    public function __construct($key, array $rules)
    {
        $this->bag = resolve('bag');
        $this->key = $key;
        $this->rules = $rules;
        $this->value = Sanitizer::input($_POST[$key]);

        $this->validate();
    }

    /**
     * Fancy constructor.
     *
     * @param mixed $key
     * @param mixed $rules
     *
     * @return self
     */
    public static function check($key, $rules)
    {
        if (!is_array($rules)) {
            $rules = [$rules];
        }

        return new self($key, $rules);
    }

    /**
     * Validate each rule.
     *
     * @return void
     */
    private function validate()
    {
        foreach ($this->rules as $rule => $message) {
            $this->enforceRule($rule, $message);
        }
    }

    /**
     * Enforce a rule, sending errors to ValidationBag.
     *
     * @param string $rule
     * @param string $message
     *
     * @return mixed
     */
    private function enforceRule($rule, $message)
    {
        list($method, $parameter) = explode(':', $rule);

        if (!method_exists(Rule::class, $method)) {
            return;
        }

        $handler = [Rule::class, $method];

        $parameters = [$this->value];

        if (isset($parameter)) {
            $parameters[] = $parameter;
        }

        if (!call_user_func_array($handler, $parameters)) {
            $this->bag[$this->key] = $message;
        }
    }
}

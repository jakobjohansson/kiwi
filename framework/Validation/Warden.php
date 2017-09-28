<?php

namespace kiwi\Http;

use kiwi\Error\HttpException;

class Warden
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
     * The handler command.
     *
     * @var array
     */
    private $handler = [];

    /**
     * The handler parameters.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * Create a new Warden instance.
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
    public static function inspect($key, $rules)
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
        if (strpos($rule, ':') !== false) {
            list($method, $parameter) = explode(':', $rule);
        }

        $this->setHandler($method ?? $rule);

        $this->setParameters($parameter ?? null);

        if (!call_user_func_array($this->handler, $this->parameters)) {
            $this->bag[$this->key] = $message;
        }
    }

    /**
     * Set a rule handler.
     *
     * @param string $method
     *
     * @throws HttpException
     *
     * @return void
     */
    private function setHandler($method)
    {
        if (!method_exists(Rule::class, $method)) {
            throw new HttpException("The {$method} rule doesn't exist.");
        }

        $this->handler = [Rule::class, $method];
    }

    /**
     * Set the handler parameters.
     *
     * @param mixed $parameter
     *
     * @return void
     */
    private function setParameters($parameter = null)
    {
        $this->parameters = [$this->value];

        if ($parameter) {
            $this->parameters[] = $parameter;
        }
    }
}

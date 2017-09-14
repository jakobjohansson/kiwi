<?php

namespace kiwi;

class Injector
{
    private $class;

    private $method;

    private $parameters;

    private $type;

    private $httpParameters;

    public function __construct($class, $methodName, $httpParameters)
    {
        $this->httpParameters = $httpParameters;
        $this->reflection = new \ReflectionClass(new $class);

        $methods = $this->reflection->getMethods();

        array_walk($methods, function($method) use ($methodName) {
            if ($method->name === $methodName) {
                $this->method = $method;
                $this->parameters = $method->getParameters();
            }
        });

        foreach ($this->parameters as $parameter) {
            if ($parameter->hasType()) {
                $this->type = $parameter->getType()->__toString();
            }
        }
    }

    public function resolve()
    {
        $resolve = $this->type::from($this->httpParameters);
        return $resolve;
    }
}

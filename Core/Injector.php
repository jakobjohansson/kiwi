<?php

namespace kiwi;

class Injector
{
    /**
     * The reflected class.
     *
     * @var ReflectionClass
     */
    private $class;

    /**
     * The reflected method.
     *
     * @var ReflectionMethod
     */
    private $method;

    /**
     * The reflected parameter.
     *
     * @var ReflectionParameter
     */
    private $parameter;

    /**
     * The reflected type.
     *
     * @var ReflectionType
     */
    private $type;

    /**
     * The original parameter.
     *
     * @var string
     */
    private $httpParameters;

    /**
     * Create a new Injector instance.
     *
     * @param string $class
     * @param string $methodName
     * @param string $httpParameters
     */
    public function __construct($class, $methodName, $httpParameters)
    {
        $this->httpParameters = $httpParameters;

        $this->setReflectionClass($class)->setReflectionMethod($methodName)->setReflectionParameter();

        if (!count($this->parameters)) {
            return false;
        }

        $this->setParameterType();

        if (!is_null($this->type) && $this->typeIsBuiltIn()) {
            $type = $type->__toString();
        }
    }

    /**
     * Check if the type is built in.
     *
     * @return bool
     */
    private function typeIsBuiltIn()
    {
        return $this->type->isBuiltin();
    }

    /**
     * Set the parameter type.
     *
     * @return void
     */
    private function setParameterType()
    {
        if ($this->parameter->hasType()) {
            $this->type = $this->parameter->getType();
        }
    }

    /**
     * Set the parameter.
     *
     * @return void
     */
    private function setReflectionParameter()
    {
        $this->parameters = $this->method->getParameters()[0];
    }

    /**
     * Set the method.
     *
     * @param string $methodName
     *
     * @return $this
     */
    private function setReflectionMethod($methodName)
    {
        $methods = $this->class->getMethods();

        $this->method = array_filter($methods, function ($method) {
            return $method->name === $methodName;
        });

        return $this;
    }

    /**
     * Set the class.
     *
     * @param string $class
     *
     * @return $this
     */
    private function setReflectionClass($class) {
        $this->class = new \ReflectionClass(new $class());

        return $this;
    }

    /**
     * Resolve the class out of the Injector.
     *
     * @return object
     */
    public function resolve()
    {
        $resolve = $this->type::from($this->httpParameters);

        return $resolve;
    }
}

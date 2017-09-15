<?php

namespace kiwi\System\Templating\Compilers;

class ExpressionCompiler
{
    /**
     * The regular expression to look for.
     *
     * @var string
     */
    private $expression;

    /**
     * The content to compile.
     *
     * @var string
     */
    private $content;

    /**
     * Create a new ExpressionCompiler instance.
     *
     * @param string $content
     */
    public function __construct($content)
    {
        $this->content = $content;

        $this->setExpression();

        $this->run();
    }

    /**
     * Compile the content.
     *
     * @return void
     */
    public function run()
    {
    }

    /**
     * Set the expression.
     *
     * @return void
     */
    private function setExpression()
    {
        $this->expression = '';
    }

    /**
     * Return the compiled content.
     *
     * @return string
     */
    public function getCompiledContent()
    {
        return $this->content;
    }
}

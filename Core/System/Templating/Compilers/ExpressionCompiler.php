<?php

namespace kiwi\System\Templating\Compilers;

class ExpressionCompiler implements CompilerInterface
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
    }

    /**
     * Compile the content.
     *
     * @return void
     */
    public function run()
    {
        $this->content = preg_replace_callback($this->expression, function($matches) {
            return sprintf("<?php echo %s; ?>", $matches[1]);
        }, $this->content);
    }

    /**
     * Set the expression.
     *
     * @return void
     */
    private function setExpression()
    {
        $this->expression = '/\{(.+)\}/';
    }

    /**
     * Return the compiled content.
     *
     * @return string
     */
    public function getCompiledContent()
    {
        $this->run();

        return $this->content;
    }
}

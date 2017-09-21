<?php

namespace kiwi\Templating\Compilers;

class ExpressionCompiler implements CompilerInterface
{
    /**
     * The regular expression to look for.
     *
     * @var string
     */
    private $expression = '/\{{2}(.+)\}{2}/';

    /**
     * The content to compile.
     *
     * @var string
     */
    private $content;

    /**
     * Compile the content.
     *
     * @return void
     */
    public function compile()
    {
        $this->content = preg_replace_callback($this->expression, function ($matches) {
            return sprintf('<?php echo %s; ?>', $matches[1]);
        }, $this->content);
    }

    /**
     * Run the compiler and return the processed content.
     *
     * @param string $content
     *
     * @return string
     */
    public function run($content)
    {
        $this->content = $content;
        $this->compile();

        return $this->content;
    }
}

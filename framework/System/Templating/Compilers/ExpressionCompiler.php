<?php

namespace kiwi\System\Templating\Compilers;

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
    public function run()
    {
        $this->content = preg_replace_callback($this->expression, function ($matches) {
            return sprintf('<?php echo %s; ?>', $matches[1]);
        }, $this->content);
    }

    public function compile($content)
    {
        $this->content = $content;
        $this->run();

        return $this->content;
    }
}

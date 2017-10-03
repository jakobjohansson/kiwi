<?php

namespace kiwi\Templating\Compilers;

class ConditionalCompiler implements CompilerInterface
{
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
        $this->compileIf();
        $this->compileElseIf();
        $this->compileElse();
        $this->compileEndif();
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

    /**
     * Check for if-statements.
     *
     * @return void
     */
    private function compileIf()
    {
        $this->content = preg_replace_callback('/\@if\s\((.+)\)/', function ($matches) {
            return sprintf('<?php if (%s) { ?>', $matches[1]);
        }, $this->content);
    }

    /**
     * Check for elseif-statements.
     *
     * @return void
     */
    private function compileElseIf()
    {
        $this->content = preg_replace_callback('/\@elseif\s\((.+)\)/', function ($matches) {
            return sprintf('<?php } elseif (%s) { ?>', $matches[1]);
        }, $this->content);
    }

    /**
     * Check for else-statements.
     *
     * @return void
     */
    private function compileElse()
    {
        $this->content = preg_replace_callback('/\@else/', function () {
            return '<?php } else { ?>';
        }, $this->content);
    }

    /**
     * Check for endif-statements.
     *
     * @return void
     */
    private function compileEndif()
    {
        $this->content = preg_replace_callback('/\@endif/', function () {
            return '<?php } ?>';
        }, $this->content);
    }
}

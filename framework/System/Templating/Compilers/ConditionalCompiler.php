<?php

namespace kiwi\System\Templating\Compilers;

class ConditionalCompiler implements CompilerInterface
{
    /**
     * The regular expression to look for.
     *
     * @var string
     */
    private $expression = '/\@if\s\((.+)\)/';

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
            return sprintf('<?php if (%s) { ?>', $matches[1]);
        }, $this->content);

        $this->content = preg_replace_callback('/\@else/', function () {
            return '<?php } else { ?>';
        }, $this->content);

        $this->content = preg_replace_callback('/\@endif/', function () {
            return '<?php } ?>';
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

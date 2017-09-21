<?php

namespace kiwi\System\Templating\Compilers;

class ForeachCompiler implements CompilerInterface
{
    /**
     * The regular expression to look for.
     *
     * @var string
     */
    private $expression = '/\@foreach\s\((.+)\sas\s(.+)\)/';

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
            return sprintf('<?php foreach (%s as %s) { ?>', $matches[1], $matches[2]);
        }, $this->content);

        $this->content = preg_replace_callback('/\@endforeach/', function () {
            return '<?php } ?>';
        }, $this->content);
    }

    /**
     * Return the compiled content.
     *
     * @return string
     */
    public function compile($content)
    {
        $this->content = $content;
        $this->run();

        return $this->content;
    }
}

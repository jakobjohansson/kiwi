<?php

namespace kiwi\Templating\Compilers;

use kiwi\Filesystem\File;

class IncludeCompiler implements CompilerInterface
{
    /**
     * The regular expression to look for.
     *
     * @var string
     */
    private $expression = '/\@include\((.+)\)/';

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
            return File::read(
                str_replace('.', '/', $matches[1]) . '.view.php'
            );
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

<?php

namespace kiwi\System\Templating\Compilers;

use kiwi\System\Templating\Engine;

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

            // Includes are tricky.
            // Since they aren't part of any routes,
            // We will have to call the compiler engine manually.
            $engine = new Engine($matches[1]);
            $engine->compile();

            $realPath = str_replace('.', '/', $matches[1]) . '.view.php';
            return sprintf('<?php include "%s"; ?>', $realPath);
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

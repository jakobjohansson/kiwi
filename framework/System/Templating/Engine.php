<?php

namespace kiwi\System\Templating;

use kiwi\System\Filesystem;
use kiwi\System\Templating\Compilers\CompilerInterface;

class Engine
{
    /**
     * The path to the file to interpret.
     *
     * @var string
     */
    private $file;

    /**
     * The file content.
     *
     * @var string
     */
    private $content;

    /**
     * An array holding the values sent by the user.
     *
     * @var array
     */
    private $extracts = [];

    /**
     * An array holding the compilers.
     *
     * @var array
     */
    private $compilers = [];

    /**
     * Create a new Engine instance.
     *
     * @param string $path
     */
    public function __construct($path, array $extracts = null)
    {
        $this->path = $path;
        $this->extracts = $extracts;

        $this->storePathContent();

        $this->addCompilers(CompilerMap::get());
    }

    /**
     * Store the file's content into a string.
     *
     * @return $this
     */
    private function storePathContent()
    {
        // ob_start();
        //
        // extract($this->extracts, EXTR_SKIP);
        //
        // include $this->path;
        //
        // $this->content = ob_get_clean();
        $this->content = file_get_contents($this->path);
    }

    /**
     * Add a compiler to the engine.
     *
     * @param CompilerInterface $compiler
     */
    public function addCompiler(CompilerInterface $compiler)
    {
        $this->compilers[] = $compiler;
    }

    /**
     * Add an array of compilers to the engine.
     *
     * @param array $compilers
     */
    public function addCompilers(array $compilers)
    {
        foreach ($compilers as $compiler) {
            $this->addCompiler(new $compiler($this->content));
        }
    }

    /**
     * Compile the directives in the file.
     *
     * @return void
     */
    public function compile()
    {
        foreach ($this->compilers as $compiler) {
            $this->content = $compiler->getCompiledContent();
        }

        $this->addContentToStorage();
    }

    private function addContentToStorage()
    {
        Filesystem::remove('cache/' . basename($this->path));
        Filesystem::write($this->content, 'cache/' . basename($this->path));
    }
}

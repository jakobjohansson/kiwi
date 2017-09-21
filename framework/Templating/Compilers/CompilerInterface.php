<?php

namespace kiwi\Templating\Compilers;

interface CompilerInterface
{
    public function compile();

    public function run($content);
}

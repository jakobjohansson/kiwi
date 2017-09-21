<?php

namespace kiwi\System\Templating\Compilers;

interface CompilerInterface
{
    public function compile();

    public function run($content);
}

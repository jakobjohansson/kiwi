<?php

namespace kiwi\System\Templating\Compilers;

interface CompilerInterface
{
    public function run();

    public function getCompiledContent();
}

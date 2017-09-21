<?php

namespace kiwi\Templating;

class CompilerMap
{
    /**
     * Return a map of the compilers to use.
     *
     * @return array
     */
    public static function get()
    {
        return [
            \kiwi\Templating\Compilers\IncludeCompiler::class,
            \kiwi\Templating\Compilers\ExpressionCompiler::class,
            \kiwi\Templating\Compilers\ForeachCompiler::class,
            \kiwi\Templating\Compilers\ConditionalCompiler::class
        ];
    }
}

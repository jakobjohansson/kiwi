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
            Compilers\IncludeCompiler::class,
            Compilers\ExpressionCompiler::class,
            Compilers\ForeachCompiler::class,
            Compilers\ConditionalCompiler::class
        ];
    }
}

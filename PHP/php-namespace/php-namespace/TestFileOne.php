<?php
namespace Foo\Bar\SubNameSpace;

const FOO = 1;

function foo()
{
    var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
}

class foo
{
    public static function staticMethod()
    {
        var_dump(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS));
    }
}
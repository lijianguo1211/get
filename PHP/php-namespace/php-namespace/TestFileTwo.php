<?php
namespace Foo\Bar;

include './TestFileOne.php';

const FOO = 2;

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


//非限定名称

foo();
/**
 * array(1) {
[0] =>
array(3) {
'file' =>
string(58) "F:\WWW\get\PHP\php-namespace\php-namespace\TestFileTwo.php"
'line' =>
int(24)
'function' =>
string(11) "Foo\Bar\foo"
}
}
 */

foo::staticMethod();

/**
 * array(1) {
[0] =>
array(5) {
'file' =>
string(58) "F:\WWW\get\PHP\php-namespace\php-namespace\TestFileTwo.php"
'line' =>
int(39)
'function' =>
string(12) "staticMethod"
'class' =>
string(11) "Foo\Bar\foo"
'type' =>
string(2) "::"
}
}
 */

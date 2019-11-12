<?php
/**
 * Notes:
 * File name:${fILE_NAME}
 * Create by: Jay.Li
 * Created on: 2019/11/12 0012 10:53
 */

class ToSql
{
    public static $outputs = [];

    public static function index()
    {
        return static::$outputs;
    }

    public static function output(string $name, Closure $callback)
    {
        return static::$outputs[$name] = $callback;
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement __call() method.
    }

    public static function __callStatic($name, $arguments)
    {
        var_dump("方法：" . $name);
        var_dump("参数：" . $arguments);
    }
}
//ToSql::show('123', '123222');
ToSql::output('test', function ($sql) {
    return $sql;
});

var_dump(ToSql::index());



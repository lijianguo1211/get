<?php

interface FileLogInterface
{
    public function test();
}

/**
 * Notes:
 * User: LiYi
 * Date: 2019/6/24
 * Time: 23:19
 * Class FileLog
 */
class FileLog implements FileLogInterface
{
    public function test()
    {
        // TODO: Implement test() method.
    }

    /**
     * FileLog constructor.
     */
    public function __construct()
    {
        var_dump('construct');
    }

    /**
     * Notes:
     * Name: index
     * User: LiYi
     * Date: 2019/6/24
     * Time: 23:18
     */
    public function index()
    {
        var_dump('index');
    }

    /**
     * Notes:
     * Name: edit
     * User: LiYi
     * Date: 2019/6/24
     * Time: 23:18
     */
    public function edit()
    {
        var_dump('edit');
    }
}

function getClass($className) {
    //得到类的相关信息
    $class = new \ReflectionClass($className);
    //得到构造函数
    $construct = $class->getConstructor();
    //判断是否有构造函数
    if (is_null($construct)) {
        return $class->newInstance();
    }

    //得到构造函数的参数
    $params = $construct->getParameters();
    //判断有没有参数
    if (is_null($params)) {
        return $class->newInstance();
    }

    return $class->newInstanceArgs($params);
}


function getParams($className) {
    //得到类的相关信息
    $class = new \ReflectionClass($className);
    //得到构造函数
    $construct = $class->getConstructor();
    var_dump('得到构造函数');
    var_dump($construct);
    //得到文档注释
    $doc = $class->getDocComment();
    var_dump('得到文档注释');
    var_dump($doc);
    //得到方法数组
    $methods = $class->getMethods();
    var_dump('得到方法数组');
    var_dump($methods);
    //得到接口
    $insterface = $class->getInterfaces();
    var_dump('得到接口');
    var_dump($insterface);
    //得到接口名称
    $insterfaceName = $class->getInterfaceNames();
    var_dump('得到接口名称');
    var_dump($insterfaceName);
}

getParams(\FileLog::class);

### php的反射机制

反射其实不是PHP独有的，比如Java就也有，反射机制，在百度百科上面也有专门的反射解释。当然这些都是值程序当中的，不是平时生活中的镜子反射。
这里引用百度百科的解释：
> 赞德斯从事互联网应用开发十余年，目前是雅虎公司工程师 [1]  ,其编著的《深入PHP：面向对象、模式与实践（第3版）》全面深入地剖析了面向对象的
PHP编程与设计。书中首先介绍了PHP的对象特性（包括抽象类、反射、接口和错误处理等）及可帮助开发人员了解类、对象和方法的对象工具，然后介绍了设计
模式。阐述了模式的概念，展示了如何在PHP中实现一些关键的模式。并用专门的章节介绍了企业模式和数据库模式。最后，本书围绕PHP应用程序开发。详细介
绍了一批极为实用的辅助开发工具。讨论了具有普遍意义的最佳开发实践。另外，这一版中还新增了闭包、命名空间、持续集成等内容

当然在[PHP的网站](https://www.php.net/manual/zh/intro.reflection.php)也有介绍。

PHP中反射的概念时候从PHP5以后才有完整的API，添加了对类，接口，函数，方法和扩展进行反向工程的能力。
比如：
官方提供的相关的API介绍

* 得到一个类相关的信息`ReflectionClass implements Reflector {}`

* 得到构造函数 `getConstructor()`

* 得到构造函数参数 `getConstructor()`

* 得到文档注释 `getDocComment()`

* 得到方法数组 `getMethods()`

* 得到接口 `getInterfaces()`

* 得到接口名称 `getInterfaceNames()`

* 得到类名 `getName()`

* 得到命名空间 `getNamespaceName()`

* 获取父类 `getParentClass()`

* 获取一组属性 `getProperties()`

比如现在有一个类`FileLog`:

```php
<?php

/**
 * Notes:
 * User: LiYi
 * Date: 2019/6/24
 * Time: 23:19
 * Class FileLog
 */
class FileLog
{
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

getClass(\FileLog::class)->index();
getClass(\FileLog::class)->edit();

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
```

利用反射，我们可以做很多事情，其实我们经常就会使用到，但是呢，我们没有仔细去注意，比如比较火的laravel框架
这个里面就使用到了它，laravel的容器中。



























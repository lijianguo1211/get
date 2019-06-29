### 控制反转，依赖注入

这里先不说概念，只先看两个最小修普通的小demo;

在`routine`这个文件里，先创建一下几个文件：

1. InterfaceLog.php 声明的一个接口文件
2. FileLog.php 这个实现上面接口的类
3. DatabaseLog.php 这个实现上面接口的类
4. User.php 这个具体的操作类

一下是代码实现：

```php
interface InterfaceLog
{
    public function write();
}

class FileLog implements InterfaceLog
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('文件日志模式');
    }
}

class DatabaseLog implements InterfaceLog
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('数据库日志模式');
    }
}

class User
{
    private $file;

    public function __construct()
    {
        $this->file = new FileLog();
    }

    public function login()
    {
        echo 'login is success!!!';
        $this->file->write();
    }
}

$user = new User();
$user->login();
```

在这个具体的user类里，有一个构造方法，有一个私有函数，在构造函数里，实例化不同的类赋值给私有变量file.
也就是，要实现不同的方式来写日志，就需要来改这个user类的控制器里的赋值方法。

接下来，实现一个灵活点的例子，就是改变不同方式日志写的方式的时候，不需要去改这个类内部的代码。
具体需要在controller里创建的文件：

1. 定义一个接口文件，Logs.php
2. 文件方式实现写日志的类，FileLog.php
3. 数据库方式实现写日志的类，DatabaseLog.php
4. 具体的逻辑处理类

```php
interface Logs
{
    public function write();
}

class FileLog implements Logs
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('文件记录日志');
    }
}

class DatabaseLog implements Logs
{
    public function write()
    {
        // TODO: Implement write() method.
        var_dump('数据库记录日志');
    }

}

class User
{
    private $file;

    public function __construct(DatabaseLog $log)
    {
        $this->file = $log;
    }

    public function login()
    {
        var_dump('login is success!!!');
        $this->file->write();
    }
}

$user = new User(new DatabaseLog());
$user->login();
```
在这里，就不需要改变逻辑类里面的代码，想要改用不同的写文件的方法，只需要在实例化user类的时候，传递不同的
实现Logs的接口类就可以了。

从上面的两个例子就可以看出，在改变程序内部需求的时候，不需要改变内部的依赖关系，而是靠从外面传递参数，进而改变类内部的依赖的方法，也就是控制反转。
> 控制反转IOC（inversion of control）： 控制反转是将组件间的依赖关系从程序内部提到外部来管理，说了控制反转，那就不能不说依赖注入。它们一般就是难兄难弟的关系，使用的时候也是差不多一起出现的。
> 依赖注入DI（dependency injection）：依赖注入是指将组件的依赖通过外部以参数或其他形式注入

在laravel这个框架中，这两个使用的还是比较多的，比如最常见的就是，在控制器的方法里，通过`request`类的方法的接受参数的时候，如下：

```php
<?php
class User
{
    public function store(\Illuminate\Http\Request $request)
    {
        $params = $request->all();
        //或者
        $id = $request->get('id');
    }
}
```

*******************************************

说到这里，可能我们还需要知道一个词就是 **反射** [PHP反射](https://www.php.net/manual/zh/book.reflection.php)

>PHP自5.0版本以后添加了反射机制，它提供了一套强大的反射API，允许你在PHP运行环境中，访问和使用类、方法、属性、参数和注释等，其功能十
分强大，经常用于高扩展的PHP框架，自动加载插件，自动生成文档，甚至可以用来扩展PHP语言。由于它是PHP內建的oop扩展，为语言本身自带的特
性，所以不需要额外添加扩展或者配置就可以使用

这里可以做拿User类做一下测试：

```php
//获取User的reflectionClass对象

$reflector  = new reflectionClass(User::class);

var_dump($reflector);

//得到user的构造函数

$controller = $reflector->getConstructor();

var_dump($controller);

// 拿到User的构造函数的所有依赖参数

$params = $controller->getParameters();

var_dump($params);

// 创建user对象,没有参数的
$user = $reflector->newInstance();

var_dump($user);

$user->login();
```

以上是构造函数没有参数的情况下，就很简单就构造了user类，并且调用login()方法也是成功了。

简单封装一下：

```php
    public function make($class)
    {
        // 获取User的reflectionClass对象
        $reflector = new \reflectionClass($class);
        //得到构造函数
        $controller = $reflector->getConstructor();
        //判断构造函数
        if (!is_null($controller)) {
            //得到构造函数的参数，依赖项
            $params = $controller->getParameters();
            //判断是否有依赖项
            if (is_null($params)) {
                //直接得到对象
                $result = $reflector->newInstance();
            } else {
                //有参数,递归创建
                $instances = $this->recursionMake($params);
                $result = $reflector->newInstanceArgs($instances);
            }
        } else {
            $result = $reflector->newInstance();
        }

        return $result;
    }

    public function recursionMake($params)
    {
        $recursionMake = [];
        foreach ($params as $param) {
            $recursionMake[] = $this->make($param->getClass()->name);
        }

        return $recursionMake;
    }
```

到这里，反射基本就出来了，就是要熟悉一下PHP的反射类：

1. 反射类 `reflectionClass`
2. 通过反射类得到构造函数 `getConstructor()`
3. 通过构造函数得到依赖参数 `getParameters()`
4. 没有依赖项的直接创建 `newInstance()`
5. 有依赖项的递归创建，最后再根据我们得到的参数，创建我们得到的类 `newInstanceArgs()`

*****************************************************************************************

继续简要实现laravel ioc容器

```php
class Ioc
{
    public $binding = [];

    public function buid($abstract, $concrete)
    {
        $this->binding[$abstract]['concrete'] = function ($ioc) use ($concrete) {
            return $ioc->build($concrete);
        };
    }

    public function make($abstract)
    {
        $concrete = $this->binding[$abstract]['concrete'];

        return $concrete;
    }

    public function build($class)
    {
        $reflector = new \reflectionClass($class);

        //得到构造函数
        $controller = $reflector->getConstructor();
        //判断构造函数是否存在
        if (is_null($controller)) {
            $result = $reflector->newInstance();
        } else {
            //得到依赖项
            $params = $controller->getParameters();
            //判断是否有依赖项
            if (is_null($params)) {
                $result = $reflector->newInstance();
            } else {
                $inctances = $this->recursionBuild($params);
                $result = $reflector->newInstanceArgs($inctances);
            }
        }

        return $result;
    }

    public function recursionBuild($params)
    {
        $recursionBuild = [];
        foreach ($params as $param) {
            $recursionBuild[] = $this->build($param->getClass()->name);
        }

        return $recursionBuild;
    }
}
```
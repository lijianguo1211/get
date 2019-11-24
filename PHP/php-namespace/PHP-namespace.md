## 命名空间

* 命名空间通过关键字`namespace`来声明

* 命名空间必须在一个文件的最上面，它的声明以上不允许有任何代码，除了`declare`关键字之外。

* 可以通过`__NAMESPACE__`来得到当前命名空间的名字

#### 使用命名空间的基础 

* 相对文件命名形式， `foo.php` 它会被解析为`currentdirectory/foo.php`,其中`currentdirctory`表示当前目录，因此如果当前目录是`/hoo/foo`,
则该文件被解析为`/home/foo/foo.php`

* 相对路径名形式 `subdirectory/foo.php`,它会被解析为`currendirectory/subdirectory/foo.php`

* 绝对路径形式 `/main/foo.php`,它会被解析为 `/main/foo.php`

* 非限定名称，或不包含前缀的类名称

* 限定名称，或包含前缀的名称，例如：

```php
<?php
namespace SubNameSpance;
$a = new Test\Foo();

Test\Foo::staticMethod();
```

以上`Foo`类是被解析为`SubNameSpance\Test\Foo`

* 完全限定名称，或包含了全局前缀操作符的名称，例如：

```php
<?php
$a = new \Test\Foo();

\Test\Foo::staticMethod();
```

* 测试文件

```php
//one.php
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
?>
//two.php
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
?>

```

在two.php文件中开始测试：

1. 调用 `foo()`函数。这个时候就是非限定名称，那么此时调用的就是two.php的`foo()`函数，同理调用定义的常量 `FOO`它也是`two.php`的，调用类
的静态方法`staticMethod()`,它们都是属于非限定名称形式的调用，都是`two.php`的。

2. 如果是限定名称形式的调用呢，首先是看`one.php`和`two.php`的命名空间，`one.php => Foo\Bar\SubNameSpace`, `two.php => Foo\Bar`,
它们命名空间前两个是相同的，即`Foo\Bar`, 那么此时在`two.php`里想要调用`foo()`函数，就可以这样做 `SubNameSpace\foo()`最终就会被解析为:
当前命名空间加上手动调用的，==》 `Foo\Bar\SubNameSpace\foo()`,调用类和常量是同理

3. 完全限定，就是在`two.php`调用`a.php`的函数，类，常量，以及方法等等，在调用的时候需要加上`one.php`的命名空间,就是这样：`\Foo\Bar\SubNameSpace\foo()`


* 注意：

> 导入操作是在编译执行的，但动态的类名称、函数名称或常量名称则不是。
导入操作只影响非限定名称和限定名称。完全限定名称由于是确定的，故不受导入的影响。

* 全局空间： 没有定义命名空间的PHP文件，都算是属于全局的命名空间：例子，使用全局的命名空间

```php
<?php

namespace App;

function fopen(string $file)
{
    return \fopen($file);//下面就是使用全局的命名fopen函数，完全限定名称
}

```

* 名称解析规则

>1.对完全限定名称的函数，类和常量的调用在编译时解析。

```php
<?php

new \A\B();

//解析为 命名空间A下面的B类
```

>2.所有的非限定名称和限定名称（非完全限定名称）根据当前的导入规则在编译时进行转换

```php
<?php
namespace A\B;

class T1
{
    
}

new C\D\T2();
?>

<?php
namespace A\B\C\D;

class T2
{
    
}
?>

//在命名空间是A\B里调用T2;最终解析为 A\B\C\D\T2();
```

>3.在命名空间内部，所有的没有根据导入规则转换的限定名称均会在其前面加上当前的命名空间名称


>4.非限定类名根据当前的导入规则在编译时转换（用全名代替短的导入名称）

>5.在命名空间内部（例如A\B），对非限定名称的函数调用是在运行时解析的。例如对函数 foo() 的调用是这样解析的：
   在当前命名空间中查找名为 A\B\foo() 的函数
   尝试查找并调用 全局(global) 空间中的函数 foo()。
   
>6.在命名空间（例如A\B）内部对非限定名称或限定名称类（非完全限定名称）的调用是在运行时解析的。下面是调用 new C() 及 new D\E() 的解析过程： new C()的解析:
  在当前命名空间中查找A\B\C类。
  尝试自动装载类A\B\C。
  new D\E()的解析:
  在类名称前面加上当前命名空间名称变成：A\B\D\E，然后查找该类。
  尝试自动装载类 A\B\D\E。   


















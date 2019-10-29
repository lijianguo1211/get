### Cannot use a scalar value as an array in

在做foreach循环的时候，提示错误 Cannot use a scalar value as an array in

意思就是我们不正当，或者不规范的使用数组。具体的例子就是，先定义一个变量

```php
$a = 0;
``` 

然后我们再次擦做这个变量，使用数组的方式给这个变量赋值：
```php
$a[1] = 10;
```

这个时候，php 就会报这个错误， **Cannot use a scalar value as an array in**

所以在弱类型的语言里，一定要按照强类型语言的习惯要求自己，不然很多由于不好编码习惯的错误都会出现

